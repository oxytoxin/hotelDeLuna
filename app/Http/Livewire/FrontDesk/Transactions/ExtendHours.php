<?php

namespace App\Http\Livewire\FrontDesk\Transactions;

use App\Models\Guest;
use Livewire\Component;
use App\Models\Extension;
use App\Models\CheckInDetail;
use App\Models\ExtensionCapping;
use Illuminate\Support\Facades\DB;
use App\Models\CheckInDetailExtension;

class ExtendHours extends Component
{
    public $branch_extension_resetting_time = null;

    public $available_hours_for_extension_with_in_this_branch = [];

    public $form = [
        'extension_id' => null,
    ];

    public $total_extension_hours;

    public $check_in_detail_id;

    public $guest_id;

    public $guest = null;

    public $initial_amount_to_reset;

    public $check_in_detail = null;


    protected $validationAttributes = [
        'form.extension_id' => 'extension',
    ];

    public function time_is_resetting()
    {
        return $this->total_extension_hours % $this->branch_extension_resetting_time == 0;
    }

    public function updatedFormExtensionId()
    {
        DB::beginTransaction();
        $extension = Extension::find($this->form['extension_id']);
    }

    public function has_already_changed_room()
    {
        return $this->check_in_detail->room_changes->count() > 0;
    }

    public function load_initial_amount_to_reset()
    {
        if ($this->has_already_changed_room()) {
            $this->initial_amount_to_reset = $this->check_in_detail->room_changes()->latest()->first()->amount;
        } else {
            $this->initial_amount_to_reset = $this->check_in_detail->static_amount;
        }
    }

    public function mount()
    {
        $this->available_hours_for_extension_with_in_this_branch = Extension::where('branch_id', auth()->user()->branch_id)->get();
        $this->guest = Guest::find($this->guest_id);
        $this->branch_extension_resetting_time = ExtensionCapping::where('branch_id', auth()->user()->branch_id)->first()->hours;
        $this->check_in_detail = CheckInDetail::find($this->check_in_detail_id);
        $this->total_extension_hours = CheckInDetailExtension::where('check_in_detail_id', $this->check_in_detail_id)->sum('hours') == 0 ?
            $this->check_in_detail->static_hours_stayed
            : CheckInDetailExtension::where('check_in_detail_id', $this->check_in_detail_id)->sum('hours') + $this->check_in_detail->static_hours_stayed;
        $this->load_initial_amount_to_reset();
    }

    public function hydrate()
    {
        $this->total_extension_hours = CheckInDetailExtension::where('check_in_detail_id', $this->check_in_detail_id)->sum('hours');
    }

    public function render()
    {
        return view('livewire.front-desk.transactions.extend-hours');
    }
}
