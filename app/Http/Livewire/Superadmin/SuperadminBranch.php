<?php

namespace App\Http\Livewire\Superadmin;

use Livewire\Component;
use App\Models\Branch;
use App\Models\User;
use Livewire\WithPagination;
use WireUi\Traits\Actions;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class SuperadminBranch extends Component
{
    use Actions;
    public $branch_id;
    public $search_user = '';
    public $addBranchModal = false;
    public $user_id;
    public $modal = 'branch';
    public $name;
    public $branches;
    public $address;
    public $user_name;
    public $user_email;
    public $user_password;
    public $user_role;
    use withPagination;
    public function mount()
    {
        $this->branch_id = request('id');
    }

    public function render()
    {
        $this->branches = Branch::where('id', $this->branch_id)->first();
        return view('livewire.superadmin.superadmin-branch', [
            'users' => User::where('branch_id', $this->branch_id)->where('name', 'like', '%' . $this->search_user . '%')->paginate(15),
            'roles' => Role::all(),
        ]);
    }

    public function editBranch()
    {
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

    public function saveUsers()
    {
        $this->validate([
            'user_name' => 'required',
            'user_email' => 'required|email',
            'user_password' => 'required',
            'user_role' => 'required',
        ]);

        $user = User::create([
            'name' => $this->user_name,
            'email' => $this->user_email,
            'password' => Hash::make($this->user_password),
            'role_id' => $this->user_role,
            'branch_id' => $this->branch_id,
        ]);

        $this->addBranchModal = false;
        $this->notification()->success(

            $title = 'Branch User',

            $description = 'User Saved Successfully.',

        );
    }

    public function editUser($id)
    {
        $this->addBranchModal = true;
        $this->modal = 'edit_users';
        $branch = User::where('id', $id)->where('branch_id', $this->branch_id)->first();
        $this->user_id = $branch->id;
        $this->user_name = $branch->name;
        $this->user_email = $branch->email;
        $this->user_role = $branch->role_id;
    }

    public function updateUser()
    {
        $this->validate([
            'user_name' => 'required',
            'user_email' => 'required|email',
            'user_password' => 'required',
            'user_role' => 'required',
        ]);

        $user = User::where('id', $this->user_id)->where('branch_id', $this->branch_id);

        $user->update([
            'name' => $this->user_name,
            'email' => $this->user_email,
            'password' => Hash::make($this->user_password),
            'role_id' => $this->user_role,
        ]);

        $this->addBranchModal = false;
        $this->notification()->success(

            $title = 'Branch User',

            $description = 'User Updated Successfully.',

        );
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
