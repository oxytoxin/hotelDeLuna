<?php

namespace App\Http\Livewire\V2\BranchAdmin\Users;

use App\Models\Role;
use App\Models\User;
use App\Models\RoomBoy;
use App\Models\Transaction;
use Livewire\Component;
use App\Traits\WithCaching;
use Livewire\WithPagination;

class Index extends Component
{
    use WithCaching, WithPagination;

    public $editMode = false;

    public $search = '';

    public $roles = [];

    public $name, $email , $password, $role_id ;

    public $user;

    protected $listeners = ['confirmDelete'];

    public function getUsersQueryProperty()
    {
        return User::query();
    }

    public function getUsersProperty()
    {
        if ($this->search) {
            $this->usersQuery->where('name', 'like', '%' . $this->search . '%')->orWhere('email', 'like', '%' . $this->search . '%');
        } 
        return $this->cache(function () {
            return $this->usersQuery->with('role')->paginate(10);
        },'users');
    }
    
    public function create()
    {
        $this->useCacheRows();
        $this->editMode = false;
        $this->dispatchBrowserEvent('show-modal');
    }

    public function save()
    {
        if ($this->editMode) {
            $this->update();
        } else {
            $this->store();
        }
    }

    public function store()
    {
        $this->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
            'role_id' => 'required',
        ]);
        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => bcrypt($this->password),
            'role_id' => $this->role_id,
            'branch_id' => auth()->user()->branch_id,
            'branch_name' => auth()->user()->branch->name
        ]);

        if ($user->role_id == room_boy()) {
            RoomBoy::create([
                'user_id' => $user->id,
            ]);
        }

        $this->dispatchBrowserEvent('close-modal');

        $this->dispatchBrowserEvent('notify',[
            'type' => 'success',
            'title' => 'User Created Successfully',
            'message' => 'User Created Successfully'
        ]);

    }

    public function delete($user_id)
    {
        $this->useCacheRows();

        $lastTransaction = Transaction::where('user_id', $user_id)->latest()->first();

        if ($lastTransaction) {
            $this->dispatchBrowserEvent('confirm',[
                'title' => 'Are you sure?',
                'message' => 'The last transaction of this user is on '. $lastTransaction->created_at->format('d M Y') .'. Are you sure you want to delete this user?',
                'confirmButtonText' => 'Continue', // default 'Confirm'
                'cancelButtonText' => 'No', // default 'Cancel',
                'confirmMethod' => 'confirmDelete', // must register in protected $listeners property of livewire ex. protected $listener = ['confirm'];
                'confirmParams' => $user_id,
             ]);
        }else{
            $this->dispatchBrowserEvent('confirm',[
                'title' => 'Are you sure?',
                'message' => 'This user has no transaction history. Are you sure you want to delete this user?',
                'confirmButtonText' => 'Continue', // default 'Confirm'
                'cancelButtonText' => 'No', // default 'Cancel',
                'confirmMethod' => 'confirmDelete', // must register in protected $listeners property of livewire ex. protected $listener = ['confirm'];
                'confirmParams' => $user_id,
             ]);
        }

    }

    public function confirmDelete($user_id)
    {
        $user = User::find($user_id);
        $user->delete();
        $this->dispatchBrowserEvent('notify',[
            'type' => 'success',
            'title' => 'User Deleted Successfully',
            'message' => 'User Deleted Successfully'
        ]);
    }

    public function edit(User $user)
    {
        $this->useCacheRows();
        $this->user = $user;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->editMode = true;
        $this->dispatchBrowserEvent('show-modal');
    }

    public function update()
    {
        $this->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$this->user->id,
        ]);
        $this->user->update([
            'name' => $this->name,
            'email' => $this->email,
        ]);

        $this->dispatchBrowserEvent('close-modal');

        $this->dispatchBrowserEvent('notify',[
            'type' => 'success',
            'title' => 'User Updated Successfully',
            'message' => 'User Updated Successfully'
        ]);
    }

    
    public function mount()
    {
        $this->roles = Role::whereNot('id', 6)->get();
    }

    public function render()
    {
        return view('livewire.v2.branch-admin.users.index',[
            'users' => $this->users,
        ]);
    }
}
