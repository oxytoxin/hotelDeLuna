<?php

namespace App\Http\Livewire\BranchAdmin;

use Livewire\Component;
use WireUi\Traits\Actions;
use App\Models\Extension;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;

class Extensions extends Component
{

    use WithPagination, Actions;

    public $search = '';

    public $mode = 'create';

    public $showModal = false;

    public $hours, $amount;

    public $edit_id = null;

    public $extension = null;

    public function getModalTitle()
    {
        return $this->mode == 'create' ? 'Add New Extend Amount' : 'Edit Extend Amount';
    }

    public function add()
    {
        $this->reset('hours', 'amount');
        $this->mode = 'create';
        $this->showModal = true;
    }

    public function create()
    {
        $this->validate([
            'hours' => 'required',
            'amount' => 'required|numeric|min:1',
        ]);

        $exist_in_this_branch = Extension::where('hours', $this->hours)
            ->where('amount', $this->amount)
            ->where('branch_id', auth()->user()->branch_id)
            ->exists();

        if ($exist_in_this_branch) {
            $this->notification()->error(
                $title = 'Error',
                $message = 'Extension details with this hours and amount already exist in this branch'
            );
            return;
        }
        Extension::create([
            'hours' => $this->hours,
            'amount' => $this->amount,
            'branch_id' => auth()->user()->branch_id,
        ]);

        $this->reset('hours', 'amount');
        $this->notification()->success(
            $title = 'Success',
            $description = 'Extend Amount has been added successfully.'
        );
        $this->showModal = false;
    }

    public function edit($extend_amount_id)
    {
        $this->mode = 'edit';
        $this->extension = Extension::find($extend_amount_id);
        $this->hours = $this->extension->hours;
        $this->amount = $this->extension->amount;
        $this->showModal = true;
    }

    public function update()
    {
        $this->validate([
            'hours' => 'required',
            'amount' => 'required|numeric|min:1',
        ]);

        DB::beginTransaction();
        $exist_in_this_branch_except_this = Extension::where('hours', $this->hours)
            ->where('amount', $this->amount)
            ->where('branch_id', auth()->user()->branch_id)
            ->where('id', '!=', $this->extension->id)
            ->exists();

        if ($exist_in_this_branch_except_this) {
            $this->notification()->error(
                $title = 'Error',
                $message = 'Extension details with this hours and amount already exist in this branch'
            );
            return;
        }

        $this->extension->update([
            'hours' => $this->hours,
            'amount' => $this->amount,
        ]);
        DB::commit();
        $this->reset('hours', 'amount');
        $this->notification()->success(
            $title = 'Success',
            $description = 'Successfully Updated'
        );
        $this->showModal = false;
    }

    public function render()
    {
        return view('livewire.branch-admin.extensions', [
            'extend_amounts' => auth()->user()->branch->extensions()
                ->when($this->search != '', function ($query) {
                    $query->where('hours', 'like', '%' . $this->search . '%')
                        ->orWhere('amount', 'like', '%' . $this->search . '%');
                })
                ->paginate(10)
        ]);
    }
}
