<?php

namespace App\Http\Livewire\V2\BranchAdmin\FrontDesks;

use Livewire\Component;
use App\Traits\WithCaching;
use App\Models\Frontdesk;
use Livewire\WithPagination;
class Index extends Component
{
    use WithCaching, WithPagination;

    //listeners

    //public properties
    public $editMode = false;
    public $frontdesk;

    //protected properties

    public function mount()
    {
        //code ....a
    }

    public function rules()
    {
        return [
            'frontdesk.branch_id' => 'required',
            'frontdesk.name' => 'required|unique:frontdesks,name,'.$this->frontdesk->id,
            'frontdesk.contact_number' => 'nullable|numeric|digits:11',
            'frontdesk.is_active' => 'nullable',
        ];
    }

    public function render()
    {
        return view('livewire.v2.branch-admin.front-desks.index',[
            'frontDesks' => $this->frontDesks,
        ]);
    }

    public function getFrontDesksQueryProperty()
    {
        return Frontdesk::where('branch_id',auth()->user()->branch_id);
    }

    public function getFrontDesksProperty()
    {
        return $this->cache( function () {
            return $this->frontDesksQuery->paginate(10);
        }, 'front-desks');
    }

    public function makeFrontDesk()
    {
        $this->frontdesk = Frontdesk::make([
            'branch_id' => auth()->user()->branch_id,
            'is_active' => true,
        ]);
    }

    public function create()
    {
        $this->useCacheRows();
        $this->makeFrontDesk();
        $this->editMode = false;
        $this->dispatchBrowserEvent('show-modal');
    }

    public function edit(Frontdesk $frontdesk)
    {
        $this->useCacheRows();
        $this->frontdesk = $frontdesk;
        $this->editMode = true;
        $this->dispatchBrowserEvent('show-modal');
    }

    public function save()
    {
        $this->validate();
        $this->frontdesk->save();
        $this->makeFrontDesk();
        $this->dispatchBrowserEvent('close-modal');
        $message = $this->editMode ? 'Front Desk updated successfully' : 'Front Desk created successfully';
        $this->dispatchBrowserEvent('notify-alert', [
            'type' => 'success',
            'title' => 'Success',
            'message' => $message,
        ]);
    }
}
