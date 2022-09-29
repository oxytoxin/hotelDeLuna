<?php

namespace App\Http\Livewire\FrontDesk;

use App\Models\Guest;
use Livewire\Component;
use WireUi\Traits\Actions;
class GuestTransactions extends Component
{
    use Actions;

    public $search = '';

    public $guest = null;

    protected $queryString = ['search'];

    public $action = null;

    public $transaction_order = 'ASC';

 

    public function search($type=null)
    {
        if ($type == '') {
            $type = 'qr';
        }
        if($this->search == ''){
            $this->guest = null;
            return;
        }
        
        switch ($type) {
            case 'qr':
                $this->guest = Guest::query()
                    ->where('qr_code', $this->search)
                    ->where('is_checked_in', 1)
                    ->where('totaly_checked_out',0)
                    ->first();
                break;
            case 'room':
                $this->guest = Guest::query()
                    ->whereHas('check_in_details', function ($query) {
                        return $query->whereHas('room', function ($query) {
                            return $query->where('number', $this->search);
                        });
                    })
                    ->where('is_checked_in', 1)
                    ->first();
                break;
        }
        // clear query string
        $this->queryString = [];
        if ($this->guest) {
            $this->queryString['search'] = $this->search;
        }else{
            $this->guest = null;
            $this->notification()->error(
                $title = 'Guest Not Found',
                $description = 'Guest with this QR Code is not checked in or already checked out'
            );
        }
    }

    public function toogleTransactionOrder()
    {
        if ($this->transaction_order == 'ASC') {
            $this->transaction_order = 'DESC';
        }else{
            $this->transaction_order = 'ASC';
        }
    }

    public function clear()
    {
        $this->search = '';
        $this->action = null;
        $this->guest = null;
    }


    public function mount()
    {
        if ($this->search != '') {
            $this->search('qr');
        }
    }

    public function render()
    {
        return view('livewire.front-desk.guest-transactions');
    }
}
