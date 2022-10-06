<?php

namespace App\Http\Livewire\Superadmin;

use App\Models\Branch;
use App\Models\Role;
use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Hash;
use WireUi\Traits\Actions;

class BranchUser extends Component
{
    use Actions;
    public $branch_id;
    public $search_user = '';
    public $user_name;
    public $user_email;
    public $roles;
    public $user_password;
    public $user_role = 1;
    public $branch_modal = false;
    public $modal_edit = false; 
    

    public function mount($branch)
    {
        $this->branch_id = $branch;
        $this->roles = Role::all();
    }
  
    public function render()
    {
        return view('livewire.superadmin.branch-user',[
            'users' => User::where('branch_id', $this->branch_id)->where('name', 'like', '%' . $this->search_user . '%')->with(['role'])->paginate(10),
           
        ]);
    }

    public function saveUsers()
    {

        $this->validate([
            'user_name' => 'required',
            'user_email' => 'required|unique:users,email',
            'user_password' => 'required',
            'user_role' => 'required',
        ]);

        $user = User::create([
            'name' => $this->user_name,
            'email' => $this->user_email,
            'password' => Hash::make($this->user_password),
            'role_id' => $this->user_role,
            'branch_id' => $this->branch_id,
            'branch_name' => Branch::where('id', $this->branch_id)->first()->name,
        ]);

        $this->branch_modal = false;
        $this->reset('user_name','user_email','user_password','user_role');
        $this->notification()->success(

            $title = 'Branch User',

            $description = 'User Saved Successfully.',

        );
    }

    public function editUser($id)
    {
        $this->branch_modal = true;
        $this->modal_edit = true;
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
            'user_email' => 'required|email|unique:users,email,'.$this->user_id,
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

        $this->branch_modal = false;
        $this->modal_edit = false;
        $this->reset('user_name','user_email','user_password','user_role');
        $this->notification()->success(

            $title = 'Branch User',

            $description = 'User Updated Successfully.',

        );
    }
}
