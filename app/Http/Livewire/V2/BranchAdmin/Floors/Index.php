<?php

namespace App\Http\Livewire\V2\BranchAdmin\Floors;

use App\Models\Floor;
use Livewire\Component;
use App\Traits\WithCaching;

class Index extends Component
{

    use WithCaching;

    public $floor;

    public $floorModalMode = 'create';

    public function rules()
    {
        return [
            'floor.number' => 'required|unique:floors,number,' . $this->floor->id,
            'floor.branch_id' => 'required',
        ];
    }

    public function makeFloorForm()
    {
        $this->floor = Floor::make(['branch_id' => auth()->user()->branch_id]);
    }

    public function getFloorsQueryProperty()
    {
        return Floor::where('branch_id', auth()->user()->branch->id);
    }

    public function getFloorsProperty()
    {
        return $this->cache(function () {
            return $this->floorsQuery->get();
        },'floors');
    }

    public function createFloor()
    {
        $this->useCacheRows();
        $this->makeFloorForm();
        $this->floorModalMode = 'create';
        $this->dispatchBrowserEvent('show-floor-modal');
    }

    public function save()
    {
        if($this->floorModalMode == 'create'){
            $this->storeFloor();
        }else{
            $this->updateFloor();
        }
    }

    public function storeFloor()
    {
        $this->validate([
            'floor.number' => 'required|unique:floors,number',
        ]);

        $this->floor->save();

        $this->dispatchBrowserEvent('close-floor-modal');

        $this->dispatchBrowserEvent('notify', [
            'type' => 'success',
            'title' => 'Floor Created',
            'message' => 'Floor created successfully!'
        ]);
    }

    public function edit(Floor $floor)
    {
        $this->useCacheRows();
        $this->floor = $floor;
        $this->floorModalMode = 'edit';
        $this->dispatchBrowserEvent('show-floor-modal');
    }

    public function updateFloor()
    {
        $this->validate([
            'floor.number' => 'required|unique:floors,number,' . $this->floor->id,
        ]);

        $this->floor->save();

        $this->dispatchBrowserEvent('close-floor-modal');

        $this->dispatchBrowserEvent('notify', [
            'type' => 'success',
            'title' => 'Floor Updated',
            'message' => 'Floor updated successfully!'
        ]);
    }

    public function render()
    {
        return view('livewire.v2.branch-admin.floors.index',[
            'floors' => $this->floors,
        ]);
    }
}
