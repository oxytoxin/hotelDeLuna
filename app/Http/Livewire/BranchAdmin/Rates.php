<?php

namespace App\Http\Livewire\BranchAdmin;

use App\Models\Rate;
use App\Models\StayingHour;
use App\Models\Type;
use Livewire\Component;
use Livewire\WithPagination;
use WireUi\Traits\Actions;
use App\Traits\Modal;

class Rates extends Component
{
    use WithPagination, Actions;

    public $showModal = false;

    public $mode = 'create';

    protected $listeners = ['edit'];

    public $staying_hour_id = '';

    public $room_type_id = '';

    public $amount;

    public $type = [];

    public $hours = [];


    public $edit_id = null;

    public $type_labels = [];

    public $rate = null;

    protected function rules()
    {
        if ($this->mode == 'create') {
            return [
                'staying_hour_id' => 'required',
                'room_type_id' => 'required',
                'amount' => 'required|numeric|min:1',
            ];
        } else {
            return [
                'staying_hour_id' => 'required',
                'amount' => 'required|numeric|min:1',
            ];
        }
    }

    public function edit($edit_id)
    {
        $this->rate = Rate::find($edit_id);
        $this->staying_hour_id = $this->rate->staying_hour_id;
        $this->room_type_id = $this->rate->type_id;
        $this->amount = $this->rate->amount;
        $this->mode = 'edit';
        $this->showModal = true;
    }

    public function create()
    {
        $this->validate();

        $rate_exists = Rate::where('staying_hour_id', $this->staying_hour_id)
            ->where('type_id', $this->room_type_id)
            ->where('amount', $this->amount)
            ->where('branch_id', auth()->user()->branch_id)
            ->exists();

        if ($rate_exists) {
            $this->notification()->error(
                $title = 'Rate already exists',
                $description = 'The rate you are trying to add already exists.'
            );
            return;
        }

        Rate::create([
            'branch_id' => auth()->user()->branch->id,
            'staying_hour_id' => $this->staying_hour_id,
            'type_id' => $this->room_type_id,
            'amount' => $this->amount,
        ]);

        $this->clear_fields_and_close_modal();


        $this->notification()->success(
            $title = 'Success',
            $description = 'Rate created successfully'
        );
    }

    public function update()
    {
        $this->validate();
        
        $rate_exitst = Rate::where('staying_hour_id', $this->staying_hour_id)
            ->where('type_id', $this->room_type_id)
            ->where('amount', $this->amount)
            ->where('branch_id', auth()->user()->branch_id)
            ->where('id', '!=', $this->rate->id)
            ->first();

        if ($rate_exitst) {
            $this->notification()->error(
                $title = 'Rate already exists',
                $description = 'The rate you are trying to add already exists.'
            );
            return;
        }
        $this->rate->update([
            'staying_hour_id' => $this->staying_hour_id,
            'amount' => $this->amount,
        ]);

        $this->clear_fields_and_close_modal();
        

        $this->notification()->success(
            $title = 'Success',
            $description = 'Rate updated successfully'
        );
    }

    public function mount()
    {
        $this->hours = StayingHour::where('branch_id', auth()->user()->branch_id)->get();
        
    }
    public function render()
    {
        return view('livewire.branch-admin.rates',[
            'types' => Type::where('branch_id', auth()->user()->branch->id)->with(['rates.staying_hour'])->get(),
        ]);
    }

   
    public function clear_fields_and_close_modal()
    {
        $this->reset('staying_hour_id', 'room_type_id', 'amount');
        $this->showModal = false;
    }

    public function getModalTitle()
    {
        return $this->mode == 'create' ? 'Add New Rate' : 'Edit Rate';
    }

    public function add()
    {
        $this->reset('staying_hour_id', 'room_type_id', 'amount');
        $this->mode = 'create';
        $this->showModal = true;
    }
}
