<?php

namespace App\Http\Livewire\FrontDesk;

use App\Models\Room;
use App\Models\Guest;
use Livewire\Component;
use WireUi\Traits\Actions;
use App\Models\Transaction;
use App\Models\CheckInDetail;
use App\Models\Deposit;
use App\Models\RoomTransactionLog;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Termwind\Components\Dd;
use App\Traits\WithCaching;
class CheckOutGuest extends Component
{
    use Actions, WithCaching;

    public $override = [
        'modal' => false,
        'new_amount',
        'authorization_code',
    ];

    protected $validationAttributes = [
        'override.new_amount' => 'new amount',
        'override.authorization_code' => 'authorization code',
    ];

    public $overridable = null;

    public $search = '';

    public $transactionOrder = 'DESC';

    public $final_reminder = false;

    public $searchBy = null;

    protected $queryString = ['search', 'searchBy'];

    public function showOverrideModal($transaction_id)
    {
        $this->overridable['authorization_code'] = "";
        $this->overridable = Transaction::find($transaction_id);
        $this->override['modal'] = true;
        $this->override['new_amount'] = $this->overridable->payable_amount;
    }

    public function overrideTransaction()
    {
        $authorization_code = auth()->user()->branch->authorization_code;
        $this->validate([
            'override.new_amount' => 'required|numeric',
            'override.authorization_code' => 'required|in:' . $authorization_code,
        ]);
        $this->overridable->update([
            'payable_amount' => $this->override['new_amount'],
            'override_at' => now()
        ]);
        $this->notification()->success(
            $title = 'Success',
            $description = 'Transaction has been overridden'
        );
        $this->override['modal'] = false;
        $this->overridable = null;
    }

    public function toogleTransactionOrder()
    {
        $this->transactionOrder = $this->transactionOrder == 'DESC' ? 'ASC' : 'DESC';
    }
    public function search($searchBy)
    {
        $this->searchBy = $searchBy;
    }

    public function payTransaction($transaction_id)
    {
        $this->useCacheRows();
        $this->dialog()->confirm([
            'title'       => 'Are you Sure?',
            'description' => 'This will mark this transaction as paid',
            'icon'        => 'question',
            'accept'      => [
                'label'  => 'Yes, Pay',
                'method' => 'confirmPayTransaction',
                'params' => $transaction_id,
            ],
            'reject' => [
                'label'  => 'No, cancel',
            ],
        ]);
    }

    public function confirmPayTransaction($transaction_id)
    {
        $transaction = $this->guest->transactions()->find($transaction_id);
        $transaction->update([
            'paid_at' => now(),
        ]);
        $this->dialog()->success(
            $title = 'Transaction Paid',
            $description = 'Transaction has been marked as paid'
        );
        $this->guest->refresh();
    }

    public function clear()
    {
        $this->search = '';
        $this->searchBy = null;
    }

    public function checkOutFalse()
    {
        $this->notification()->error(
            $title = 'Error!',
            $description = 'Please pay all transactions first.'
        );
    }

    public function checkOut()
    {
        $this->useCacheRows();
        $has_unpaid_transaction = $this->guest->transactions()->where('paid_at', null)->exists();
        if ($has_unpaid_transaction) {
            $this->checkOutFalse();
            return;
        }
        $this->dialog()->confirm([
            'title'       => 'Remider',
            'description' => 'Hand over by the guest/room boy the key and remote',
            'icon'        => 'info',
            'accept'      => [
                'label'  => ' Next',
                'method' => 'reminderTwo',
            ],
            'reject' => [
                'label'  => 'Cancel',
            ],
        ]);
    }

    public function reminderTwo()
    {
        $this->useCacheRows();
        $this->dialog()->confirm([
            'title'       => 'Remider',
            'description' => 'Check room by the body',
            'icon'        => 'info',
            'accept'      => [
                'label'  => ' Next',
                'method' => 'reminderthree',
            ],
            'reject' => [
                'label'  => 'Cancel',
            ],
        ]);
    }

    public function reminderthree()
    {
        $this->useCacheRows();
        $this->dialog()->confirm([
            'title'       => 'Remider',
            'description' => 'Call guest to check-out in Kiosk',
            'icon'        => 'info',
            'accept'      => [
                'label'  => ' Next',
                'method' => 'final_reminder_done',
            ],
            'reject' => [
                'label'  => 'Cancel',
            ],
        ]);
    }

    public function final_reminder_done()
    {
        $this->dialog()->confirm([
            'title'       => 'Are you Sure?',
            'description' => 'This will check out this guest',
            'icon'        => 'question',
            'accept'      => [
                'label'  => 'Yes, Check Out',
                'method' => 'confirmCheckOut',
            ],
            'reject' => [
                'label'  => 'No, cancel',
            ],
        ]);
    }

    public function confirmCheckOut()
    {
        DB::beginTransaction();
        $this->guest->update([
            'totaly_checked_out' => true,
            'check_out_at' => now(),
        ]);
        $check_in_detail = $this->guest->checkInDetail;
        $check_in_detail->update([
            'check_out_at' => now(),
        ]);
        $check_in_detail->room->update([
            'room_status_id' => 7,
            'time_to_clean' => Carbon::now()->addHours(3),
            'last_check_out_at' => Carbon::now(),
        ]);

        $check_in_detail->room->roomTransactionLogs()->latest()->first()->update([
            'check_out_at' => now(),
        ]);
        
        DB::commit();
        $this->notification()->success(
            $title = 'Guest Checked Out',
            $description = 'Guest has been checked out'
        );
        $this->guest = null;
        $this->search = '';
        $this->searchBy = null;
    }

    public function getGuestQueryProperty()
    {
        return Guest::where('branch_id', auth()->user()->branch->id)
            ->where('terminated_at', null)
            ->whereNotNull('check_in_at',)
            ->where('totaly_checked_out', false);
    }

    public function getGuestProperty()
    {
        if (is_null($this->search)) return null;

        if ($this->searchBy == "qr_code") {
            $this->guestQuery->where('qr_code', $this->search);
        } else {
            $this->guestQuery->whereHas('checkInDetail.room', function ($query) {
                        $query->where('number', $this->search);
             });
        }

        return $this->cache(function () {
            return $this->guestQuery->with(['checkInDetail','transactions.transaction_type'])
                ->withSum(
                    'transactions','payable_amount',
                )
                ->first();
        });
    }

    public function getTransactionsQueryProperty()
    {
       return  $this->guest->transactions;
    }

    public function getTransactionsProperty()
    {
       return $this->transactionsQuery->groupBy('transaction_type_id');
    }

    public function getDepositsQueryProperty()
    {
        return Deposit::where('guest_id', $this->guest->id);
    }

    public function getDepositsProperty()
    {
       return $this->cache(function () {
            return $this->depositsQuery->get();
        },'deposits');
    }

    public function claimDeposit($deposit_id)
   {
        $deposit = $this->deposits->find($deposit_id);
        if ($deposit->claimed_at) {
            $this->dialog()->error(
                $title = 'Error',
                $message = 'Deposit is already claimed',
            );
            return;
        }
        
        if ($deposit->amount == $deposit->deducted) {
            $this->dialog()->error(
                $title = 'Error',
                $message = 'Deposit is already fully deducted',
            );
            return;
        }
        $deposit->update([
            'claimed_at' => now(),
        ]);
        $this->dialog()->success(
            $title = 'Deposit Claimed',
            $message = 'Deposit has been claimed',
        );
    }
   
    public function render()
    {
        return view('livewire.front-desk.check-out-guest', [
            'guest_transactions' => $this->guest ? $this->transactions : [],
            'transaction_types' => $this->guest ? \App\Models\TransactionType::get() : [],
            'total_amount_to_pay'=> $this->guest ? $this->guest->transactions->sum('payable_amount') : 0,
            'balance' => $this->guest ? $this->guest->transactions->whereNull('paid_at')->sum('payable_amount') : 0,
            'deposits' => $this->guest ? $this->deposits : [],
        ]);
    }
}
