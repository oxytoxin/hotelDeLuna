<?php

namespace App\Http\Livewire\V2\BranchAdmin\Users;

use App\Models\Role;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;
use App\Traits\WithCaching;
class Index extends Component
{
    use WithCaching, WithPagination;
    public $form;

    public $editMode = false;

    public $search = '';

    public $roles = [];

    public function rules()
    {
        return [
            'form.branch_id' => 'required',
            'form.branch_name' => 'required',
            'form.name' => 'required',
            'form.email' => 'required|email|unique:users,email,' . $this->form->id,
            'form.role_id' => $this->editMode ? 'nullable' : 'required',
            'form.password' => $this->editMode ? 'nullable' : 'required',
        ];
    }

    public function makeForm()
    {
        $this->form =  User::make([
            'branch_id' => auth()->user()->branch_id,
            'branch_name' => auth()->user()->branch->name
        ]);
    }

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
        $this->makeForm();
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
        $this->validate();
        $this->form->save();
        if ($this->form->role_id == room_boy()) {
            RoomBoy::create([
                'user_id' => $this->form->id,
            ]);
        }
        $this->dispatchBrowserEvent('hide-modal');
        $this->makeForm();
    }

    public function edit(User $user)
    {
        $this->useCacheRows();

        $this->form = $user;
        $this->editMode = true;
        $this->dispatchBrowserEvent('show-modal');
    }

    public function update()
    {
        $this->validate([
            'form.name' => 'required',
            'form.email' => 'required|email|unique:users,email,' . $this->form->id,
            'form.role_id' =>'nullable',
            'form.password' =>'nullable',
        ]);
        $this->form->save();
        $this->dispatchBrowserEvent('hide-modal');
        $this->makeForm();
    }

    
    public function mount()
    {
        $this->makeForm();
        $this->roles = Role::whereNot('id', 6)->get();
    }

    public function render()
    {
        return view('livewire.v2.branch-admin.users.index',[
            'users' => $this->users,
        ]);
    }
}
