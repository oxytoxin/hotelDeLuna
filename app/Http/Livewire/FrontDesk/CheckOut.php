<?php

namespace App\Http\Livewire\FrontDesk;

use App\Models\CheckInDetail;
use App\Models\Damage;
use App\Models\Guest;
use App\Models\Room;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use WireUi\Traits\Actions;

class CheckOut extends Component
{
    use Actions;

    public $guest = null;

    public $realSearch = '';

    public $searchBy = '';

    public $search = '';

    public $transaction_id;

    public function setGuest()
    {
        if ($this->realSearch != '') {
            switch ($this->searchBy) {
                case '1':
                    $this->guest = $this->searchByQrCode();
                    break;
                case '2':
                    $this->guest = $this->searchByRoom();
                    break;
                case '3':
                    $this->guest = $this->searchByContactNumber();
                    break;
            }
        } else {
            return false;
        }
    }

    public function search($searchBy)
    {
        $this->realSearch = $this->search;
        $this->searchBy = $searchBy;
        $this->setGuest();
        $this->reset('search');
    }

    public function searchByQrCode()
    {
        return Guest::query()
            ->where('qr_code', $this->realSearch)
            ->where('is_checked_in', 1)
            ->where('totaly_checked_out', 0)
            ->whereHas('transactions.check_in_detail', function ($query) {
                return $query->where('check_in_at', '!=', null);
            })
            ->with([
                'transactions' => [
                    'check_in_detail' => [
                        'room',
                    ],
                ],
            ])
            ->first();
    }

    public function searchByRoom()
    {
        $room = Room::where('number', $this->realSearch)->whereHas('floor', function ($query) {
            return $query->where('branch_id', auth()->user()->branch_id);
        })->first();

        if (!$room) {
            $this->notification()->error(
                $title = 'Room not found',
                $description = 'Room number ' . $this->realSearch . ' not found in this branch.'
            );
            return false;
        }

        $check_in_detail = CheckInDetail::query()
            ->where('room_id', $room->id)
            ->where('check_in_at', '!=', null)
            ->where('check_out_at', null)
            ->first();
        if ($check_in_detail) {
            $guest = $check_in_detail->transaction->guest;
            if ($guest->is_checked_in == 1 && $guest->totaly_checked_out == 0) {
                return $guest;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function searchByContactNumber()
    {
        return Guest::query()
            ->where('contact_number', $this->realSearch)
            ->where('is_checked_in', 1)
            ->where('totaly_checked_out', 0)
            ->whereHas('transactions.check_in_detail', function ($query) {
                return $query->where('check_in_at', '!=', null);
            })
            ->with([
                'transactions' => [
                    'check_in_detail' => [
                        'room',
                    ],
                ],
            ])
            ->first();
    }

    public function pay($transaction_id)
    {
        $transaction = $this->guest->transactions->where('id', $transaction_id)->first();
        $transaction->update([
            'paid_at' => now(),
        ]);
    }

    public function checkOut($transaction_id)
    {
        $this->dialog()->confirm([
            'title' => 'Are you Sure?',
            'description' => 'You are about to check out this room.',
            'icon' => 'question',
            'accept' => [
                'label' => 'Yes, Check Out',
                'method' => 'checkOutConfirm',
                'params' => $transaction_id,
            ],
            'reject' => [
                'label' => 'No, cancel',
            ],
        ]);
    }

    public function checkOutConfirm($transaction_id)
    {
        $transaction = Transaction::find($transaction_id);
        DB::beginTransaction();
        $transaction->check_in_detail->update([
            'check_out_at' => Carbon::now(),
        ]);
        $transaction->check_in_detail->room->update([
            'room_status_id' => 7,
            'time_to_clean' => Carbon::now()->addHours(3),  // with in 3 hours after check out, the room must be cleaned by the bell boy
        ]);
        DB::commit();
        $this->notification()->success(
            $title = 'Success',
            $description = 'Room has been checked out!'
        );
    }

    public function totalyCheckOutGuest()
    {
        foreach ($this->guest->transactions->where('transaction_type_id', 1) as $transaction) {
            if ($transaction->check_in_detail->check_out_at == null) {
                $this->notification()->error(
                    $title = 'Error',
                    $description = "You can't totaly check out this guest because he/she has not checked out from all rooms!"
                );

                return;
            }
        }
        $this->dialog()->confirm([
            'title' => 'Are you Sure?',
            'description' => 'You are about to check out this room.',
            'icon' => 'question',
            'accept' => [
                'label' => 'Yes, Check Out',
                'method' => 'totalyCheckOutConfirm',
            ],
            'reject' => [
                'label' => 'No, cancel',
            ],
        ]);
    }

    public function totalyCheckOutConfirm()
    {
        $balance = $this->guest->transactions->where('paid_at', null)->sum('payable_amount') + $this->guest->damages->where('paid_at', null)->sum('payable_amount');
        if ($balance === 0) {
            $this->guest->update([
                'totaly_checked_out' => 1,
            ]);
            $this->notification()->success(
                $title = 'Success',
                $description = 'Guest has been totaly checked out!'
            );
            $this->realSearch = '';
        } else {
            $this->notification()->error(
                $title = 'Error',
                $description = "You can't totaly check out this guest because he/she has not paid for all transactions!"
            );

            return;
        }
    }

    public function payDamage($damage_id)
    {
        $this->dialog()->confirm([
            'title' => 'Are you Sure?',
            'description' => 'Do you want to continue?',
            'icon' => 'question',
            'accept' => [
                'label' => 'Yes, Pay',
                'method' => 'confirmPayDamage',
                'params' => $damage_id,
            ],
            'reject' => [
                'label' => 'No, cancel',
            ],
        ]);
    }

    public function confirmPayDamage($damage_id)
    {
        $damage = Damage::find($damage_id);
        $damage->update([
            'paid_at' => now(),
        ]);
        $this->notification()->success(
            $title = 'Success',
            $description = 'Damage has been paid!'
        );
    }

    public function render()
    {
        return view('livewire.front-desk.check-out', [
            'transactions' => $this->guest != null ?
                $this->guest->transactions()
                ->with(['transaction_type'])
                ->orderBy('created_at', 'desc')
                ->get()
                : [],
            'damages' => $this->guest != null ?
                $this->guest->damages()
                ->get()
                : [],
        ]);
    }
}
