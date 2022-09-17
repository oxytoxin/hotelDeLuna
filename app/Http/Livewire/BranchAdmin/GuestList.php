<?php

namespace App\Http\Livewire\BranchAdmin;

use App\Models\Guest;
use Livewire\Component;
use Livewire\WithPagination;

class GuestList extends Component
{
    use WithPagination;

    public $filter = [
        'status' => 'all',
    ];

    public $search = '';

    public function render()
    {
        return view('livewire.branch-admin.guest-list', [
            'guests' => Guest::query()
                ->when($this->search != '', function ($query) {
                    $query->where('name', 'like', '%'.$this->search.'%')
                        ->orWhere('phone', 'like', '%'.$this->search.'%')
                        ->orWhere('qr_code', 'like', '%'.$this->search.'%');
                })
                ->where('is_checked_in', true)
                ->paginate(10),
        ]);
    }
}
