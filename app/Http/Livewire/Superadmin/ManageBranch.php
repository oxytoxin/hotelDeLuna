<?php

namespace App\Http\Livewire\Superadmin;

use Livewire\Component;
use App\Models\Branch;

class ManageBranch extends Component
{
    public $name;
    public $address;
    public $branchModal = false;
    public function render()
    {
        return view('livewire.superadmin.manage-branch',[
            'branches' => Branch::get(),
        ]);
    }

    public function createBranch(){
        $this->validate([
            'name' => 'required',
            'address' => 'required',
        ]);
        Branch::create([
            'name' => $this->name,
            'address' => $this->address,
        ]);
        $this->name = '';
        $this->address = '';
        $this->branchModal = false;
    }
}
