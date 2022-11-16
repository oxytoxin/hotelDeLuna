<?php

namespace App\Http\Livewire\V2\BranchAdmin\ExtensionRates;

use Livewire\Component;
use App\Models\Extension;
use App\Traits\WithCaching;
use Livewire\WithPagination;

class Index extends Component
{
    use WithCaching, WithPagination;

    public $editMode = false;

    public $search = '';

    public $form;

    public $listeners = ['deleteExtensionRate'];

    public function rules()
    {
        return [
            'form.branch_id' => 'required',
            'form.hours' => 'required|unique:extensions,hours,' . $this->form->id,
            'form.amount' => 'required|numeric',
        ];
    }

    public function getExtensionsQueryProperty()
    {
        return Extension::where('branch_id', auth()->user()->branch_id);
    }

    public function getExtensionsProperty()
    {

        if ($this->search) {
            $this->extensionsQuery->where('hours', 'like', '%' . $this->search . '%');
        }

        return $this->cache(function () {
            return $this->extensionsQuery->paginate(10);
        },'extensions');
    }

    public function makeForm()
    {
        $this->form = Extension::make([
            'branch_id' => auth()->user()->branch->id,
        ]);
    }
    public function mount()
    {
        $this->makeForm();
    }
    public function create()
    {
        $this->editMode = false;
        $this->makeForm();
        $this->dispatchBrowserEvent('show-modal');
    }
    public function save()
    {
        if ($this->editMode) {
            $this->update();
        } else {
            $this->store();
        }
    }
    public function store()
    {
        $this->validate();
        $this->form->save();
        $this->dispatchBrowserEvent('close-modal');
        $this->makeForm();
        $this->dispatchBrowserEvent('notify',[
            'type' => 'success',
            'title' => 'Extension Rate Created',
            'message' => 'Extension Rate has been created successfully'
        ]);
    }

    public function edit(Extension $extension)
    {
        $this->editMode = true;
        $this->form = $extension;
        $this->dispatchBrowserEvent('show-modal');
    }

    public function update()
    {
        $this->validate();
        $this->form->save();
        $this->dispatchBrowserEvent('close-modal');
        $this->makeForm();
        $this->dispatchBrowserEvent('notify',[
            'type' => 'success',
            'title' => 'Extension Rate Created',
            'message' => 'Extension Rate has been updated successfully'
        ]);
    }

    public function deleteExtensionRate($extensionRateId)
    {
        $extensionRate = Extension::find($extensionRateId);
        $extensionRate->delete();
        $this->dispatchBrowserEvent('notify',[
            'type' => 'success',
            'title' => 'Extension Rate Deleted',
            'message' => 'Extension Rate has been deleted successfully'
        ]);
    }
    public function render()
    {
        return view('livewire.v2.branch-admin.extension-rates.index',[
            'extensions' => $this->extensions,
        ]);
    }
}
