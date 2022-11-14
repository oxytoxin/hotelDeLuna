<?php

namespace App\Http\Livewire\V2\BranchAdmin\Rates;

use App\Models\Rate;
use App\Models\Type;
use Livewire\Component;
use WireUi\Traits\Actions;
use App\Models\StayingHour;
use App\Traits\WithCaching;

class Index extends Component
{
    use WithCaching, Actions;

    public $editMode = false;

    public $stayingHours = [];

    public $roomTypes = [];

    public $form;

    public function makeForm()
    {
        $this->form = Rate::make(['branch_id' => auth()->user()->branch_id]);
    }

    public function getRateGroupedByTypeQueryProperty()
    {
        return  Type::where('branch_id', auth()->user()->branch->id)->with(['rates.staying_hour']);
    }

    public function getRateGroupedByTypeProperty()
    {
        return $this->cache(function () {
            return $this->rateGroupedByTypeQuery->get();
        },'rateGroupedByType');
    }

    public function create()
    {
        $this->useCacheRows();
        $this->editMode = false;
        $this->dispatchBrowserEvent('show-create-modal');
    }


    public function mount()
    {
        $this->stayingHours = StayingHour::where('branch_id', auth()->user()->branch->id)->get('id', 'number');
        $this->roomTypes = Type::where('branch_id', auth()->user()->branch->id)->get('id', 'name');
        $this->makeForm();
    }

    public function render()
    {
        return view('livewire.v2.branch-admin.rates.index',[
            'types' => $this->rateGroupedByType,
        ]);
    }
}
