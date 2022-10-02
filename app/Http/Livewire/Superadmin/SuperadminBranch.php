<?php

namespace App\Http\Livewire\Superadmin;

use Livewire\Component;
use App\Models\Branch;
use App\Models\Floor;
use App\Models\Rate;
use App\Models\User;
use Livewire\WithPagination;
use WireUi\Traits\Actions;
use App\Models\Role;
use App\Models\Room;
use App\Models\Type;
use Illuminate\Support\Facades\Hash;


class SuperadminBranch extends Component
{
    use WithPagination;
    use Actions;
    public $branch_id;
    public $addBranchModal = false;
    public $tab = 'users';
    public $user_id;
    public $modal = 'branch';
    public $name;
    public $branches;
    public $total_users;
    public $total_rooms;
    public $total_rates;
    public $total_types;
    public $address;
   
    public $floor_number;
   
    public $floor_modal = false;
    use withPagination;
    public function mount()
    {
        $this->branch_id = request('id');
        $this->total_users = User::where('branch_id', $this->branch_id)->count();
        $this->total_rooms = Room::whereHas('floor', function($query){
            $query->where('branch_id', $this->branch_id);
        })->with('floor')->count();
        $this->total_rates = Rate::where('branch_id', $this->branch_id)->count();
        $this->total_types = Type::where('branch_id', $this->branch_id)->count();
    }
    public function render()
    {
        $this->branches = Branch::where('id', $this->branch_id)->first();
        return view('livewire.superadmin.superadmin-branch',[
            
        ]);
    }

    public function editBranch()
    {
        $this->modal = 'branch';
        $this->name = $this->branches->name;
        $this->address = $this->branches->address;
        $this->addBranchModal = true;
    }

    public function updateBranch()
    {
        $this->validate([
            'name' => 'required',
            'address' => 'required',
        ]);
        $branch = Branch::where('id', $this->branch_id);

        $branch->update([
            'name' => $this->name,
            'address' => $this->address,
        ]);

        $this->addBranchModal = false;
        // session()->flash('message', 'Branch Updated Successfully.');
        $this->notification()->success(

            $title = 'Branch Update',

            $description = 'Branch Updated Successfully.',

        );
    }

    

    public function addUser()
    {
        $this->addBranchModal = true;
        $this->modal = 'users';
    }

    

    public function deleteDialog()
    {
        $this->dialog()->confirm([

            'title'       => 'Are you Sure?',

            'description' => 'Delete this branch? Warning: All Users and Data will be deleted.',

            'icon'        => 'question',

            'accept'      => [

                'label'  => 'Yes, delete it',

                'method' => 'deleteBranch',



            ],

            'reject' => [

                'label'  => 'No, cancel',



            ],

        ]);
    }

    public function deleteBranch(){
        // dd('delete');
        $this->branches->delete();
        redirect()->route('superadmin.branch');

    }
}
