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
use App\Models\CheckInDetailExtension;
use App\Models\Rate;
use LDAP\Result;
use Termwind\Components\Dd;

class ExtendHours extends Component
{
    use Actions;

    public $branch_extension_resetting_time = null;

    public $available_hours_for_extension_with_in_this_branch = [];

    public $form = [
        'extension_id' => null,
        'amount_to_be_paid' => null,
        'initial_amount' => null,
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
        DB::beginTransaction();
        $extension = Extension::find($this->form['extension_id']);
        $extension_history = CheckInDetailExtension::where('check_in_detail_id', $this->check_in_detail_id);
        $total_check_in_detail_extension_hours = $extension_history->sum('hours');
        $this->form['initial_amount'] = $this->check_in_detail->rate->amount;
        $total_hours = $this->check_in_detail->rate->staying_hour->number + $total_check_in_detail_extension_hours;
        $plus_extension_hours = $extension->hours + $total_hours;
        if ($plus_extension_hours > $this->branch_extension_resetting_time) {
            $qoutient = floor($plus_extension_hours / $this->branch_extension_resetting_time);
            $remainder = $plus_extension_hours % $this->branch_extension_resetting_time;
            $daily_amount = $this->checked_in_room_daily_rate * $qoutient;
            $nearest_rate = Rate::where('type_id', $this->check_in_detail->room->type_id)
                ->whereHas('staying_hour', function ($query) use ($remainder) {
                    $query->where('number', '>=', $remainder);
                })->first();
            $paid_amount = Transaction::where('guest_id', $this->guest_id)
                ->whereIn('transaction_type_id', [1, 6])
                ->sum('payable_amount');
            $temp_amount = $daily_amount + $nearest_rate->amount;
            $total_amount = $temp_amount - $paid_amount;
            $this->form['amount_to_be_paid'] = $total_amount;
        } else {
            $this->form['amount_to_be_paid'] = $extension->amount;
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
        CheckInDetailExtension::create([
            'check_in_detail_id' => $this->check_in_detail_id,
            'extension_id' => $this->form['extension_id'],
            'hours' => $extension->hours,
            'amount' => $this->form['amount_to_be_paid'],
        ]);
        Transaction::create([
            'guest_id' => $this->guest_id,
            'branch_id' => auth()->user()->branch_id,
            'transaction_type_id' => 6,
            'payable_amount' => $this->form['amount_to_be_paid'],
        ]);
        $this->check_in_detail->update([
            'expected_check_out_at' => Carbon::parse($this->check_in_detail->expected_check_out_at)->addHours($extension->hours)
        ]);
        DB::commit();
        $this->reset('form');
        $this->notification()->success(
            $title = 'Success',
            $description = 'Hour extension saved successfully',
        );
    }

    public function mount()
    {
        $this->check_in_detail = CheckInDetail::where('id', $this->check_in_detail_id)->with(['rate.staying_hour'])->first();
        $this->available_hours_for_extension_with_in_this_branch = Extension::where('branch_id', auth()->user()->branch_id)->get();
        $extension_capping = $this->branch_extension_resetting_time = ExtensionCapping::where('branch_id', auth()->user()->branch_id)->first();
        $this->branch_extension_resetting_time = $extension_capping->hours ?? null;
        if ($this->branch_extension_resetting_time) {
            $this->checked_in_room_daily_rate = Rate::where('branch_id', auth()->user()->branch_id)
            ->whereHas('staying_hour', function ($query) {
                $query->where('number', $this->branch_extension_resetting_time);
            })->first()->amount;
        }
    }

    public function render()
    {
        return view('livewire.front-desk.transactions.extend-hours', [
            'extension_history' => CheckInDetailExtension::where('check_in_detail_id', $this->check_in_detail_id)
                                ->orderBy('created_at', $this->history_order)
                                ->get(),
        ]);
    }
}
