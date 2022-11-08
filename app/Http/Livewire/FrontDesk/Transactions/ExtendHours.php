<?php

namespace App\Http\Livewire\FrontDesk\Transactions;

use Carbon\Carbon;
use App\Models\Guest;
use Livewire\Component;
use App\Models\Extension;
use WireUi\Traits\Actions;
use App\Models\Transaction;
use App\Models\CheckInDetail;
use App\Models\ExtensionCapping;
use Illuminate\Support\Facades\DB;
use App\Models\StayExtension;
use App\Models\Rate;
use App\Models\StayingHour;
use App\Traits\{WithCaching,PayTransaction};

class ExtendHours extends Component
{
    use Actions, WithCaching, PayTransaction;

    public $tabIsVisible = false;

    public $branch_extension_resetting_time = null;

    public $available_hours_for_extension_with_in_this_branch = [];

    public $form = [
        'extension_id' => null,
        'amount_to_be_paid' => null,
        'initial_amount' => null,
        'paid_at' => false,
    ];

    protected $validationAttributes = [
        'form.extension_id' => 'extension hours',
        'form.amount_to_be_paid' => ' amount'
    ];

    public $total_extension_hours;

    public $check_in_detail_id;

    public $checked_in_room_daily_rate;

    public $guest_id;

    public $guest = null;

    public $initial_amount_to_reset;

    public $check_in_detail = null;

    public $history_order = 'DESC';

    public function historyOrderToggle()
    {
        $this->history_order = $this->history_order == 'ASC' ? 'DESC' : 'ASC';
    }

    public function updatedFormExtensionId()
    {
        $this->useCacheRows();
        DB::beginTransaction();
        $extension = Extension::find($this->form['extension_id']);

        // to get the sum of hours extended by the guest
        $extension_history = StayExtension::where('guest_id',$this->guest_id);
        $total_check_in_detail_extension_hours = $extension_history->sum('hours');
        $total_hours = $this->check_in_detail->static_hours_stayed + $total_check_in_detail_extension_hours;
        $total_hours_with_about_to_extend = $extension->hours + $total_hours;
        $extension_hours = $extension->hours;
        $reset_amount = StayingHour::where('branch_id', auth()->user()->branch_id)
            ->where('number', '>=', $extension_hours)
            ->orderBy('number', 'ASC')
            ->first()->rates()->where('type_id', $this->check_in_detail->room->type_id)->first()->amount;

        if ($total_hours % $this->branch_extension_resetting_time == 0) {
            if ($extension->hours < $this->branch_extension_resetting_time) {
                $this->form['amount_to_be_paid'] = $reset_amount;
            } else {
                $days = floor($extension->hours / $this->branch_extension_resetting_time);
                $hours = $extension->hours % $this->branch_extension_resetting_time;
                $daily_amount = $this->checked_in_room_daily_rate * $days;
                $hourly_rate_amount = $hours > 0 ? Rate::where('type_id', $this->check_in_detail->room->type_id)
                    ->whereHas('staying_hour', function ($query) use ($hours) {
                        $query->where('number', '>=', $hours);
                    })->first()->amount : 0;
                $total_extend_amount = StayExtension::whereHas('transaction', function ($query) {
                    $query->where('guest_id', $this->guest_id);
                })->sum('amount');
                dd($total_extend_amount);
                $total_checked_in_amount_and_extension_amount = $this->check_in_detail->rate->amount + $total_extend_amount;
                $total_amount = $daily_amount + $hourly_rate_amount;
                $this->form['amount_to_be_paid'] =  $total_amount - $total_checked_in_amount_and_extension_amount;
            }
        } else {
            if ($extension->hours + $total_hours <= $this->branch_extension_resetting_time) {
                $this->form['amount_to_be_paid'] =  $extension->amount;
            } else {
                $temp_total = $extension->hours + $total_hours;
                $days = floor($temp_total / $this->branch_extension_resetting_time);
                $hours = $temp_total % $this->branch_extension_resetting_time;
                $daily_amount = $this->checked_in_room_daily_rate * $days;
                $hourly_rate_amount =  $hours > 0 ? Rate::where('type_id', $this->check_in_detail->room->type_id)
                    ->whereHas('staying_hour', function ($query) use ($hours) {
                        $query->where('number', '>=', $hours);
                    })->first()->amount : 0;
                $total_extend_amount = StayExtension::where('guest_id', $this->guest_id)->sum('amount');

                $total_checked_in_amount_and_extension_amount = $this->check_in_detail->rate->amount + $total_extend_amount;
                $total_amount = $daily_amount + $hourly_rate_amount;
                $this->form['amount_to_be_paid'] =  $total_amount - $total_checked_in_amount_and_extension_amount;
            }
        }
        DB::commit();
    }

    public function save()
    {
        $this->validate([
            'form.amount_to_be_paid' => 'required|numeric',
            'form.extension_id' => 'required',
        ]);
        DB::beginTransaction();
        $extension = Extension::find($this->form['extension_id']);
        $extension_transaction = Transaction::create([
            'guest_id' => $this->guest_id,
            'branch_id' => auth()->user()->branch_id,
            'transaction_type_id' => 6,
            'payable_amount' => $this->form['amount_to_be_paid'],
            'room_id' => $this->check_in_detail->room_id,
            'remarks' => 'Guest extended his/her stay for ' . $extension->hours . ' hours',
            'paid_at' => $this->form['paid_at'] ? now() : null,
            'front_desk_name' => auth()->user()->name,
            'user_id' => auth()->user()->id,
        ]);
        StayExtension::create([
            'guest_id' => $this->guest_id,
            'extension_id' => $this->form['extension_id'],
            'hours' => $extension->hours,
            'amount' => $this->form['amount_to_be_paid'],
            'front_desk_name' => auth()->user()->name,
            'user_id' => auth()->user()->id,
        ]);

        $this->check_in_detail->update([
            'expected_check_out_at' => Carbon::parse($this->check_in_detail->expected_check_out_at)->addHours($extension->hours)
        ]);

        DB::commit();
        $this->reset('form');
        $this->dialog()->success(
            $title = 'Success',
            $description = 'Hour extension saved successfully',
        );
    }

    public function visible()
    {
        $this->tabIsVisible = true;
        $this->available_hours_for_extension_with_in_this_branch = Extension::where('branch_id', auth()->user()->branch_id)->get();
        $extension_capping = ExtensionCapping::where('branch_id', auth()->user()->branch_id)->first();
        $this->branch_extension_resetting_time = $extension_capping->hours ?? null;
        if ($this->branch_extension_resetting_time) {
            $this->checked_in_room_daily_rate = Rate::where('branch_id', auth()->user()->branch_id)
                ->whereHas('staying_hour', function ($query) {
                    $query->where('number', $this->branch_extension_resetting_time);
                })->first()->amount;
        }
    }

    public function mount()
    {
        $this->check_in_detail = CheckInDetail::where('id', $this->check_in_detail_id)->with(['rate.staying_hour'])->first();
    }

    // public function payTransaction($transaction_id)
    // {
    //     $this->useCacheRows();

    //     $this->dialog()->confirm([
    //         'title'       => 'Are you Sure?',
    //         'description' => 'This will mark the transaction as paid.',
    //         'icon'        => 'question',
    //         'accept'      => [
    //             'label'  => 'Yes, continue',
    //             'method' => 'confirmPayTransaction',
    //             'params' => $transaction_id,
    //         ],
    //         'reject' => [
    //             'label'  => 'No, cancel',
    //         ],
    //     ]);
    // }

    // public function confirmPayTransaction($transaction_id)
    // {
    //     $transaction = Transaction::find($transaction_id);

    //     $transaction->update([
    //         'paid_at' => Carbon::now(),
    //     ]);

    //     $this->dialog()->success(
    //         $title = 'Success',
    //         $description = 'Transaction has been marked as paid.',
    //     );

    //     $this->emit('transactionUpdated');
    // }

    public function getTransactionsQueryProperty()
    {
        return Transaction::where('guest_id', $this->guest_id)->where('transaction_type_id', 6);
    }
    
    public function getTransactionsProperty()
    {
        return $this->cache(function () {
            return $this->transactionsQuery->get();
        });
    }

    public function render()
    {
        return view('livewire.front-desk.transactions.extend-hours', [
            'transactions' => $this->tabIsVisible ? $this->transactions : [],
        ]);
    }
}
