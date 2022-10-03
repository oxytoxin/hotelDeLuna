<?php

namespace App\Http\Livewire\FrontDesk;

use App\Models\Room;
use App\Models\Guest;
use Livewire\Component;
use WireUi\Traits\Actions;
use App\Models\CheckInDetail;

class GuestTransactions extends Component
{
    use Actions;

    public $search = '';

    public $searchBy = null;

    public $guest = null;

    protected $queryString = ['search','searchBy'];

    public $action = null;

    public $transaction_order = 'ASC';

    public function searchByQrCode()
    {
        $this->searchBy = 'qr_code';
        if ($this->search) {
            $guest = Guest::where('qr_code', $this->search)
                    ->where('check_in_at', '!=', null)
                    ->where('totaly_checked_out', false)
                    ->where('branch_id', auth()->user()->branch->id)
                    ->first();
            if (!$guest) {
                $this->notification()->error(
                    $title = 'Error!',
                    $message = 'QR Code not found or already checked out.'
                );
                $this->guest = null;
                $this->search = '';
                $this->searchBy = null;
                return;
            }
            $this->guest = $guest;
            $this->queryString['search'] = $this->search;
        }
    }

    public function searchByRoomNumber()
    {
        $this->searchBy = 'room_number';
        if($this->search){
            $room = Room::where('number', $this->search)
                    ->whereHas('floor', function($query){
                        $query->where('branch_id', auth()->user()->branch_id);
                    })
                    ->where('room_status_id', 2)
                    ->first();
            if (!$room) {
                $this->notification()->error(
                    $title = 'Error!',
                    $message = 'Guest not found or already checked out.'
                );
                $this->guest = null;
                $this->search = '';
                $this->searchBy = null;
                return;
            }
            $check_in_detail = CheckInDetail::where('room_id', $room->id)
                    ->where('check_in_at', '!=', null)
                    ->where('check_out_at', null)
                    ->first();
            if (!$check_in_detail) {
                $this->notification()->error(
                    $title = 'Error!',
                    $message = 'Guest not found or already checked out.'
                );
                $this->guest = null;
                $this->search = '';
                $this->searchBy = null;
                return;
            }
            $this->guest = $check_in_detail->transaction->guest;
        }
    }

    public function searchByName()
    {
        $this->searchBy = 'name';
        if($this->search){
            $guest = Guest::where('name',$this->search)
                    ->where('check_in_at', '!=', null)
                    ->where('totaly_checked_out', false)
                    ->where('branch_id', auth()->user()->branch->id)
                    ->first();
            if (!$guest) {
                $this->notification()->error(
                    $title = 'Error!',
                    $message = 'Guest not found or already checked out.'
                );
                $this->guest = null;
                $this->search = '';
                $this->searchBy = null;
                return;
            }
            $this->guest = $guest;
        }
    }

    // public function search($type=null)
    // {
    //     if ($type == '') {
    //         $type = 'qr';
    //     }
    //     if($this->search == ''){
    //         $this->guest = null;
    //         return;
    //     }
        
    //     switch ($type) {
    //         case 'qr':
    //             $this->guest = Guest::query()
    //                 ->where('qr_code', $this->search)
    //                 ->where('is_checked_in', 1)
    //                 ->where('totaly_checked_out',0)
    //                 ->first();
    //             break;
    //         case 'room':
    //             $this->guest = Guest::query()
    //                 ->whereHas('check_in_details', function ($query) {
    //                     return $query->whereHas('room', function ($query) {
    //                         return $query->where('number', $this->search);
    //                     });
    //                 })
    //                 ->where('is_checked_in', 1)
    //                 ->first();
    //             break;
    //     }
    //     // clear query string
    //     $this->queryString = [];
    //     if ($this->guest) {
    //         $this->queryString['search'] = $this->search;
    //     }else{
    //         $this->guest = null;
    //         $this->notification()->error(
    //             $title = 'Guest Not Found',
    //             $description = 'Guest with this QR Code is not checked in or already checked out'
    //         );
    //     }
    // }

    public function toogleTransactionOrder()
    {
        if ($this->transaction_order == 'ASC') {
            $this->transaction_order = 'DESC';
        }else{
            $this->transaction_order = 'ASC';
        }
    }

    public function payTransaction($transaction_id)
    {
        $this->dialog()->confirm([
            'title'       => 'Are you Sure?',
            'description' => 'This will mark this transaction as paid',
            'icon'        => 'question',
            'accept'      => [
                'label'  => 'Yes, Pay',
                'method' => 'confirmPayTransaction',
                'params' => $transaction_id,
            ],
            'reject' => [
                'label'  => 'No, cancel',
            ],
        ]);
    }

    public function confirmPayTransaction($transaction_id)
    {
        $transaction = $this->guest->transactions()->find($transaction_id);
        $transaction->update([
            'paid_at' => now(),
        ]);
        $this->notification()->success(
            $title = 'Transaction Paid',
            $description = 'Transaction has been marked as paid'
        );
    }

    public function clear()
    {
        $this->search = '';
        $this->action = null;
        $this->guest = null;
    }


    public function mount()
    {
        if ($this->search) {
           switch ($this->searchBy) {
               case 'qr_code':
                   $this->searchByQrCode();
                   break;
               case 'room_number':
                   $this->searchByRoomNumber();
                   break;
               case 'name':
                   $this->searchByName();
                   break;
               default:
                   $this->searchByQrCode();
                   break;
           }
        }
    }

    public function render()
    {
        return view('livewire.front-desk.guest-transactions');
    }
}
