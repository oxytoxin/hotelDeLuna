<?php

namespace App\Http\Livewire\BranchAdmin;

use App\Models\Rate;
use Livewire\Component;

class RateList extends Component
{
    public function render()
    {
        return view('livewire.branch-admin.rate-list',[
            'rates'=>Rate::query()
                    ->where('branch_id',auth()->user()->branch_id)
                    ->with('staying_hour','type')
                    ->paginate(10)
        ]);
    }
}
