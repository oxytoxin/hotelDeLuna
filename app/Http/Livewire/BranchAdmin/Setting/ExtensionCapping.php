<?php

namespace App\Http\Livewire\BranchAdmin\Setting;

use Livewire\Component;
use App\Models\ExtensionCapping as ExtensionCappingModel;
use WireUi\Traits\Actions;
class ExtensionCapping extends Component
{
    use Actions;

    public $showModal=false;

    public $hours;

    public $extension_capping;

    public function save()
    {
        $this->validate([
            'hours' => 'required|numeric',
        ]);
        if ($this->extension_capping) {
            $this->extension_capping->update([
                'hours' => $this->hours,
            ]);
            $this->notification()->success(
                $title = 'Success',
                $description = 'Extension capping updated successfully'
            );
        } else {
            ExtensionCappingModel::create([
                'branch_id' => auth()->user()->branch->id,
                'hours' => $this->hours,
            ]);
            $this->notification()->success(
                $title = 'Success',
                $description = 'Extension capping created successfully'
            );
        }
        
        $this->showModal = false;
    }

    public function render()
    {
        $this->extension_capping = ExtensionCappingModel::where('branch_id',auth()->user()->branch->id)->first();
        if($this->extension_capping){
            $this->hours = $this->extension_capping->hours;
        }
        return view('livewire.branch-admin.setting.extension-capping');
    }
}
