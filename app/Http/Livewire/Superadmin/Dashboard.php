<?php

namespace App\Http\Livewire\Superadmin;

use Livewire\Component;
use App\Models\Branch;

class Dashboard extends Component
{
    public function render()
    {
        return view('livewire.superadmin.dashboard',[
            'branches' => Branch::get(),
        ]);
    }
}
