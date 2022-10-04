<?php

namespace App\Http\Livewire\BranchAdmin;

use Livewire\Component;
use Livewire\WithPagination;
class TerminatedGuestList extends Component
{
    use WithPagination;
    
    public function render()
    {
        return view('livewire.branch-admin.terminated-guest-list',[
            'guests' => \App\Models\Guest::where('terminated_at', '!=', null)->paginate(10)
        ]);
    }
}
