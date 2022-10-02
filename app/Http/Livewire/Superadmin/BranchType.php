<?php

namespace App\Http\Livewire\Superadmin;

use App\Models\Type;
use Livewire\Component;
use WireUi\Traits\Actions;

class BranchType extends Component
{
    use Actions;
    public $branch_id;
    public $create_modal = false;
    public $edit_modal = false;
    public $name;
    public $edit_id;


    public function mount($branch)
    {
        $this->branch_id = $branch;
    }

    public function render()
    {
        return view('livewire.superadmin.branch-type',[
            'types' => Type::where('branch_id', $this->branch_id)->with('branch')->get(),
        
        ]);
    }

    public function saveType(){
        $this->validate([
            'name' => 'required',
        ]);
        Type::create([
            'branch_id' => $this->branch_id,
            'name' => $this->name,
        ]);
        $this->notification()->success(
            $title = 'Type added',
            $description = 'The type has been added successfully.'
        );
        $this->create_modal = false;
        $this->name = '';
    }

    public function editType($id){
        $this->edit_modal = true;
        $query = Type::where('id', $id)->first();
        $this->name = $query->name;
        $this->edit_id = $id;

    }

    public function updateType(){
        $this->validate([
            'name' => 'required',
        ]);
        $query = Type::where('id', $this->edit_id)->first();
        $query->update([
            'name' => $this->name,
        ]);
        $this->notification()->success(
            $title = 'Type updated',
            $description = 'The type has been updated successfully.'
        );
        $this->edit_modal = false;
        $this->name = '';
    }
}
