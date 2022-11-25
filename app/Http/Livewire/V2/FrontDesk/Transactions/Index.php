<?php

namespace App\Http\Livewire\V2\FrontDesk\Transactions;

use App\Models\Guest;
use Livewire\Component;
use App\Traits\WithCaching;
class Index extends Component
{
    use WithCaching;

    public $realSearch='';

    public $search='';


    public $searchBy='1';

    public $queryString = ['realSearch','activeTab','searchBy'];

    protected $listeners = ['transactionUpdated'=>'$refresh'];

    public $tabs = [
        [
            'id' => 1,
            'name' => 'Transactions',
        ],
        [
            'id' => 2,
            'name' => 'Transfer Room',
        ],
        [
            'id' => 3,
            'name' => 'Extend',
        ],
        [
            'id' => 4,
            'name' => 'Damage Charges',
        ],
        [
            'id' => 5,
            'name' => 'Amenities',
        ],
        [
            'id' => 6,
            'name' => 'Food And Beverages',
        ],
        [
            'id' => 7,
            'name' => 'Deposits',
        ],
    ];

    public $activeTab = 1;

    public function search()
    {
        $this->realSearch = $this->search;

        if ($this->guest == null) {
            $this->dispatchBrowserEvent('notify-alert', [
                'type' => 'error',
                'title' => 'Guest Not Found',
                'message' => 'Guest not found'
            ]);
        }
    }

    public function clearSearch()
    {
        $this->search = '';
        $this->realSearch = '';
        $this->activeTab = 1;
    }

    public function getGuestQueryProperty()
    {
        return Guest::where('branch_id', auth()->user()->branch->id)
            ->where('check_in_at', '!=', null)
            ->where('is_checked_in', true)
            ->where('check_out_at', null);
    }

    public function getGuestProperty()
    {
        if ($this->realSearch != '') {
            switch ($this->searchBy) {
                case '1':
                    $this->guestQuery->where('qr_code', $this->realSearch);
                    break;
                case '2':
                    $this->guestQuery->whereHas('checkInDetail.room', function ($query) {
                        $query->where('number', $this->realSearch);
                    });
                    break;
            }
        }

        return $this->cache(function () {
            return $this->guestQuery->with(['checkInDetail.room','checkInDetail.rate.staying_hour'])->first();
        }, 'guest');
    }

    public function changeTab($tabId)
    {
        $this->useCacheRows();
        $this->activeTab = $tabId;
    }

    public function mount()
    {
        if ($this->realSearch != '') {
            $this->search = $this->realSearch;
        }
    }

    public function render()
    {
        return view('livewire.v2.front-desk.transactions.index',[
            'guest' => $this->realSearch != '' ? $this->guest : null
        ]);
    }
}
