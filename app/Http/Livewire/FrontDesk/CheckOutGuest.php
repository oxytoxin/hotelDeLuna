<?php

namespace App\Http\Livewire\FrontDesk;

use App\Models\CheckInDetail;
use App\Models\Guest;
use App\Models\Room;
use Livewire\Component;
use WireUi\Traits\Actions;

class CheckOutGuest extends Component
{
    use Actions;

    public $guest = null;

    public $search = '';

    public $transactionOrder = 'DESC';

    protected $queryString = ['search'];

    public function searchByQrCode()
    {
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
                return;
            }
            $this->guest = $guest;
            $this->queryString['search'] = $this->search;
        }
    }

    public function searchByRoomNumber()
    {
        if($this->search){
            $room = Room::where('number', $this->search)
                    ->where('branch_id', auth()->user()->branch->id)
                    ->where('room_status_id', 2)
                    ->first();
            $check_in_detail = CheckInDetail::where('room_id', $room->id)
                    ->where('check_in_at', '!=', null)
                    ->where('check_out_at', null)
                    ->first();
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

    public function mount()
    {
        if ($this->search) {
            $this->searchByQrCode();
        }
    }
    public function render()
    {
        return view('livewire.front-desk.check-out-guest',[
            'transactions' => $this->guest ? 
                        $this->guest->transactions()
                        ->with(['transaction_type', 'check_in_detail.room.type'])
                        ->orderBy('created_at',$this->transactionOrder)->get() : null,
        ]);
    }
}
