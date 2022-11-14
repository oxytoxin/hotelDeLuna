<?php

namespace App\Http\Livewire\V2\BranchAdmin\Types;

use Livewire\Component;
use App\Models\Type;
use App\Traits\WithCaching;
use Livewire\WithPagination;
use WireUi\Traits\Actions;
use App\Traits\{XNotification,ConfirmDialog};
class Index extends Component
{
    use WithCaching, WithPagination, Actions, XNotification, ConfirmDialog;

    public $form;

    public $editMode = false;

    public $search ='';

    protected $listeners = ['delete'];

    public function rules()
    {
        return [
            'form.branch_id' => 'nullable',
            'form.name' => 'required|unique:types,name,' . $this->form->id,
        ];
    }

    public function makeForm()
    {
        $this->form = Type::make(['branch_id' => auth()->user()->branch_id]);
    }
    public function getTypesQueryProperty()
    {
        return Type::where('branch_id', auth()->user()->branch_id);
    }
    public function getTypesProperty()
    {

        if ($this->search!='') {
            return $this->typesQuery->where('name', 'like', '%' . $this->search . '%')->paginate(10);
        }

        return $this->cache(function () {
            return $this->typesQuery->paginate(10);
        },'types');
    }

    public function save()
    {
        if ($this->editMode) {
            $this->update();
        } else {
            $this->store();
        }
     
    }

    public function create()
    {
        $this->useCacheRows();
        $this->editMode = false;
        $this->makeForm();
        $this->dispatchBrowserEvent('show-create-modal');
    }

    public function store()
    {
        $this->validate();

        $this->form->save();

        $this->makeForm();

        $this->dispatchBrowserEvent('notify',[
            'type' =>'success',
            'title' =>'Success!',
            'message' =>'Record has been creayed.',
        ]);

        $this->dispatchBrowserEvent('close-create-modal');

    }

    public function edit(Type $type)
    {
        $this->useCacheRows();

        $this->editMode = true;

        $this->form = $type;

        $this->dispatchBrowserEvent('show-edit-modal');
    }

    public function update()
    {
        $this->validate();

        $this->form->save();

        $this->makeForm();

        $this->editMode = false;

        $this->dispatchBrowserEvent('notify',[
            'type' =>'success',
            'title' =>'Success!',
            'message' =>'Record has been updated.',
        ]);

        $this->dispatchBrowserEvent('close-edit-modal');
    }

    public function mount()
    {
        $this->makeForm();
    }

    public function render()
    {
        return view('livewire.v2.branch-admin.types.index',[
            'types' => $this->types
        ]);
    }
}
