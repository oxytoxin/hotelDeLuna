<?php

namespace App\Http\Livewire\FrontDesk;

use App\Models\CheckInDetail;
use App\Models\Discount;
use App\Models\Guest;
use App\Models\Room;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;
use Psy\Readline\Transient;
use Termwind\Components\Dd;
use WireUi\Traits\Actions;

class CheckIn extends Component
{
    use WithPagination, Actions;

    public $search;

    public $searchBy = '1';

    public $realSearch;

    protected $listeners = ['refreshRecentCheckInList' => 'clearSearches'];

    public $showModal = false;

    public $guest = null;

    public $showDiscountsList = false;

    public $selectedDiscounts = [];

    public $discounted_amount = 0;

    public $recent_check_in_order = 'DESC';

    public function toggle_recent_check_in_order()
    {
        if ($this->recent_check_in_order == 'DESC') {
            $this->recent_check_in_order = 'ASC';
        } else {
            $this->recent_check_in_order = 'DESC';
        }
    }

    public function searchReal()
    {
        $this->realSearch = $this->search;
        $this->reset('search');
    }

    public function clearSearches()
    {
        $this->realSearch = '';
        $this->search = '';
        $this->searchBy = '1';
    }

    public function setGuest($guest_id)
    {
        $this->guest = Guest::find($guest_id);
        if ($this->guest->terminated_at != null) {
            $this->notification()->error(
                $title = 'Error',
                $description = 'Guest failed to check in within 2 hours. As per policy, guest is terminated.',
            );
            return;
        }
        $this->showModal = true;
    }

    public function confirmCheckIn()
    {
        $this->dialog()->confirm([
            'title' => 'Are you Sure?',
            'description' => 'Are you sure you want to check in this guest?',
            'icon' => 'question',
            'accept' => [
                'label' => 'Yes, Check In',
                'method' => 'checkIn',
            ],
            'reject' => [
                'label' => 'No, cancel',
            ],
        ]);
    }

    public function checkIn()
    {
        DB::beginTransaction();
        $this->guest->transactions()->update(['paid_at' => Carbon::now()]);
        foreach ($this->guest->transactions->where('transaction_type_id', 1) as  $check_in_transaction) {
            $check_in_detail = CheckInDetail::where('transaction_id', $check_in_transaction->id)->first();
            $check_in_detail->update([
                'check_in_at' => Carbon::now(),
                'expected_check_out_at' => Carbon::now()->addHours($check_in_transaction->check_in_detail->static_hours_stayed),
            ]);
            Room::where('id', $check_in_detail->room_id)->update([
                'room_status_id' => 2,
            ]);
        }
        $this->guest->update([
            'is_checked_in' => true,
            'check_in_at' => Carbon::now(),
        ]);
        DB::commit();
        $this->showModal = false;
        $this->notification()->success(
            $title = 'Success!',
            $description = 'Guest has been checked in.',
        );
    }

    public function selectDiscount($id, $amount, $is_percentage)
    {
        $array = [
            'id' => $id,
            'amount' => $amount,
            'is_percentage' => $is_percentage,
        ];

        if (in_array($array, $this->selectedDiscounts)) {
            $this->selectedDiscounts = array_filter($this->selectedDiscounts, function ($item) use ($id) {
                return $item['id'] != $id;
            });
            if ($is_percentage) {
                $amount_payable = Transaction::where('guest_id', $this->guest->id)->where('transaction_type_id', 1)->first()->payable_amount;
                $amount = ($amount_payable * $amount) / 100;
                $this->discounted_amount -= $amount;
            } else {
                $this->discounted_amount -= $amount;
            }
        } else {
            array_push($this->selectedDiscounts, $array);
            if ($is_percentage) {
                $amount_payable = Transaction::where('guest_id', $this->guest->id)->where('transaction_type_id', 1)->first()->payable_amount;
                $amount = ($amount_payable * $amount) / 100;
                $this->discounted_amount += $amount;
            } else {
                $this->discounted_amount += $amount;
            }
        }
    }

    public function searchByQrCode()
    {
        if ($this->search) {
            $guest = Guest::where('qr_code', $this->search)
                ->where('terminated_at', null)
                ->where('is_checked_in', false)
                ->where('branch_id', auth()->user()->branch->id)
                ->first();
            if (!$guest) {
                $this->notification()->error(
                    $title = 'Error!',
                    $message = 'QR Code not found'
                );
                $this->guest = null;
                $this->search = '';
                return;
            }
            return $guest;
        }
    }

    public function searchByRoomNumber()
    {
        if ($this->search) {
            $room = Room::where('number', $this->search)
                ->whereHas('floor', function ($query) {
                    $query->where('branch_id', auth()->user()->branch_id);
                })
                ->where('room_status_id', 6)
                ->first();
            if (!$room) {
                $this->notification()->error(
                    $title = 'Error!',
                    $message = 'Room not exist in the queue'
                );
                $this->search = '';
                return;
            }
            $check_in_detail = CheckInDetail::where('room_id', $room->id)
                ->where('check_in_at', null)
                ->where('check_out_at', null)
                ->latest()
                ->first();
            if (!$check_in_detail) {
                $this->notification()->error(
                    $title = 'Error!',
                    $message = 'Guest not found or already checked out.'
                );
                $this->search = '';
                return;
            }

            if ($check_in_detail->transaction->guest->terminated_at != null || $check_in_detail->transaction->guest->is_checked_in != false) {
                $this->notification()->error(
                    $title = 'Error!',
                    $message = 'Guest not found'
                );
                $this->search = '';
                return;
            }
            return $check_in_detail->transaction->guest;
        }
    }

    public function searchByName()
    {
        if ($this->search) {
            $guest = Guest::where('name', $this->search)
                ->where('terminated_at', null)
                ->where('is_checked_in', false)
                ->where('branch_id', auth()->user()->branch->id)
                ->paginate(10);
            if (!$guest) {
                $this->notification()->error(
                    $title = 'Error!',
                    $message = 'Guest not found or already checked out.'
                );
                $this->search = '';
                return;
            }
            return $guest;
        }
    }
    public function runQuery()
    {
        if ($this->realSearch != '') {
            switch ($this->searchBy) {
                case '1':
                    return $this->searchByQrCode();
                    break;
                case '2':
                    return $this->searchByName();
                    break;
                case '3':
                    return $this->searchByRoomNumber();
                    break;
            }
        } else {
            return  Guest::query()
                ->where('terminated_at', null)
                ->where('is_checked_in', false)
                ->paginate(10);
        }
    }
    public function render()
    {
        return view('livewire.front-desk.check-in', [
            'guests' => Guest::where('terminated_at', null)
                ->where('is_checked_in', false)
                ->when($this->realSearch != '', function ($query) {
                    switch ($this->searchBy) {
                        case '1':
                            $query->where('qr_code', $this->realSearch);
                            break;
                        case '2':
                            $query->where('name', $this->realSearch);
                            break;
                        case '3':
                            $query->whereHas('transactions', function ($query) {
                                $query->where('transaction_type_id', 1)
                                    ->whereHas('check_in_detail', function ($query) {
                                        $query->whereHas('room', function ($query) {
                                            $query->where('number', $this->realSearch);
                                        });
                                    });
                            });
                            break;
                    }
                })
                ->where('branch_id', auth()->user()->branch->id)
                ->paginate(10),
            'transactions' => $this->showModal != false ?
                $this->guest->transactions()
                ->with(['transaction_type', 'check_in_detail.room'])
                ->orderBy('created_at', 'desc')->get() : [],
            'recent_check_in_list' => Guest::query()
                ->where('is_checked_in', true)
                ->orderBy('check_in_at', $this->recent_check_in_order)
                ->take(10)
                ->get(),
            'discounts' => $this->showModal == true ?
                Discount::where('branch_id', auth()->user()->branch_id)
                ->where('is_available', true)
                ->get() : [],
        ]);
    }
}
