<?php

namespace App\Http\Livewire\BranchAdmin;

use App\Models\Type;
use Livewire\Component;
use WireUi\Traits\Actions;
use Livewire\WithPagination;

class Types extends Component
{
    use WithPagination, Actions;

    public $modal = [
        'show' => false,
        'mode' => 'create',
    ];
    public $type = null;

    public $form = [
        'name' => '',
    ];

    protected $validationAttributes = [
        'form.name' => 'name',
    ];

    protected function rules()
    {
        if ($this->modal['mode'] == 'create') {
            return [
                'form.name' => 'required|unique:types,name',
            ];
        } else {
            return [
                'form.name' => 'required|unique:types,name,' . $this->type->id,
            ];
        }
    }
    
    public function create()
    {
        $this->validate();

        Type::create([
            'branch_id' => auth()->user()->branch->id,
            'name' => $this->form['name'],
        ]);

        $this->notification()->success(
            $title = 'Success!',
            $message = 'Record has been created.'
        );

        $this->modal['show'] = false;

        $this->reset('form');
    }

    public function edit($type_id)
    {
        $this->modal['mode'] = 'edit';
        $this->type = Type::find($type_id);
        $this->form['name'] = $this->type->name;
        $this->modal['show'] = true;
    }

    public function update()
    {
        $this->validate();
        
        $this->type->update([
            'name' => $this->form['name'],
        ]);
        
        $this->notification()->success(
            $title = 'Success!',
            $message = 'Record has been updated.'
        );

        $this->modal['show'] = false;
    }
    public function render()
    {
        return view('livewire.branch-admin.types',[
            'types' => Type::where('branch_id',auth()->user()->branch_id)->paginate(10)
        ]);
    }


    public function getModalTitle()
    {
        return $this->modal['mode'] == 'create' ? 'Create Type' : 'Edit Type';
    }

    public function add()
    {
        $this->reset('form');
        $this->modal['mode'] = 'create';
        $this->modal['show'] = true;
    }
}
