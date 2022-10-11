<?php

namespace App\Http\Livewire\BranchAdmin;

use App\Models\Role;
use App\Models\RoomBoy;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;
use WireUi\Traits\Actions;
class Users extends Component
{
    use WithPagination, Actions;

    public $showModal = false;

    public $mode = 'create';

    public $search = '';

    public $filter = 'all';

    public $roles = [];

    public $name;

    public $email;

    public $password;

    public $role_id;

    public $edit_id = null;

    public $user=null;

    protected function rules()
    {
        if ($this->mode == 'create') {
            return [
                'name' => 'required',
                'email' => 'required|email|unique:users,email',
                'password' =>  'required',
                'role_id' => 'required',
            ];
        } else {
            return [
                'name' => 'required',
                'email' => 'required|email|unique:users,email,'.$this->edit_id,
                'role_id' => 'required',
            ];
        }
    }

    public function edit($edit_id)
    {
        $this->edit_id = $edit_id;
        $this->user = User::find($edit_id);
        $this->name = $this->user->name;
        $this->email = $this->user->email;
        $this->role_id = $this->user->role_id;
        $this->mode = 'edit';
        $this->showModal = true;
    }

    public function create()
    {
        $this->validate();
        DB::beginTransaction();
        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => bcrypt($this->password),
            'role_id' => $this->role_id,
            'branch_id' => auth()->user()->branch_id,
            'branch_name' => auth()->user()->branch->name,
        ]);
        if ($this->role_id == room_boy()) {
            RoomBoy::create([
                'user_id' => $user->id,
            ]);
        }
        DB::commit();
        $this->clear_fields_and_close_modal();
        $this->notification()->success(
            $title = 'Success',
            $description = 'User created successfully',
        );
    }

    public function update()
    {
        $this->validate();
        User::find($this->edit_id)->update([
            'name' => $this->name,
            'email' => $this->email,
            'role_id' => $this->role_id,
        ]);
        $this->clear_fields_and_close_modal();
        $this->notification()->success(
            $title = 'Success',
            $description = 'User updated successfully',
        );
    }

    public function mount()
    {
        $this->roles = Role::where('id', '!=', super_admin())->get();
    }

    public function render()
    {
        return view('livewire.branch-admin.users', [
            'users' => User::query()
                    ->where('branch_id', auth()->user()->branch_id)
                    ->when($this->search != '', function ($query) {
                        $query->where('name', 'like', '%'.$this->search.'%')
                            ->orWhere('email', 'like', '%'.$this->search.'%');
                    })
                    ->when($this->filter != 'all', function ($query) {
                        $query->where('role_id', $this->filter);
                    })
                    ->paginate(10),
        ]);
    }

    public function clear_fields_and_close_modal()
    {
        $this->showModal = false;
        $this->reset('name', 'email', 'role_id');
    }

    public function getModalTitle()
    {
        return $this->mode == 'create' ? 'Add New User' : 'Edit User';
    }

    public function add()
    {
        $this->reset('name', 'email', 'password', 'role_id');
        $this->mode = 'create';
        $this->showModal = true;
    }
}
