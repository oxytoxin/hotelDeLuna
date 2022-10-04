<?php

namespace App\Http\Livewire\BranchAdmin\Setting;

use App\Models\Branch;
use Livewire\Component;
use WireUi\Traits\Actions;
class AdminAuthorizationCode extends Component
{
    use Actions;

    public $form = ['authorization_code','old_code'];

    public $modal = [
        'show' => false,
        'title' => '',
    ];

    public function add()
    {
        $this->reset('form');
        $this->modal = [
            'show' => true,
            'title' => 'Add Authorization Code',
        ];
    }

    public function edit()
    {
        $this->modal = [
            'show' => true,
            'title' => 'Edit Authorization Code',
        ];
    }

    public function create()
    {
        $this->validate([
            'form.authorization_code' => 'required',
        ]);
        Branch::find(auth()->user()->branch->id)->update([
            'authorization_code' => $this->form['authorization_code'],
        ]);
        $this->modal['show'] = false;
        $this->notification()->success(
            $title = 'Success',
            $description = 'Authorization code updated successfully'
        );
    }
    public function update()
    {
        $this->validate([
            'form.authorization_code' => 'required',
        ]);
        $code = Branch::find(auth()->user()->branch_id)->authorization_code;
        if($this->form['old_code'] == $code){
            Branch::find(auth()->user()->branch_id)->update([
                'authorization_code' => $this->form['authorization_code'],
            ]);
            $this->modal['show'] = false;
            $this->notification()->success(
                $title = 'Success',
                $description = 'Authorization code updated successfully'
            );
        }else{
            $this->modal['show'] = false;
            $this->notification()->error(
                $title = 'Error',
                $description = 'Failed to update authorization code'
            );
        }
    }
    public function render()
    {
        return view('livewire.branch-admin.setting.admin-authorization-code',[
            'code'=>Branch::where('id',auth()->user()->branch_id)->first()->authorization_code
        ]);
    }
}
