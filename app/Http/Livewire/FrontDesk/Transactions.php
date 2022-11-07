<?php

namespace App\Http\Livewire\FrontDesk;

use Carbon\Carbon;
use App\Models\Guest;
use App\Models\Damage;
use Livewire\Component;
use App\Models\Extension;
use App\Models\Room;
use WireUi\Traits\Actions;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;

class Transactions extends Component
{
    use Actions;

    public $guest = null;

    public $searchQuery = '';

    public $searhMode = 'qr_code';

    public $showExtendModal = false, $showChangeRoomModal = false, $showDamageModal = false, $showCheckoutModal = false;

    public $extensions = [], $availableRoomToChange = [];

    public $extension = ['extension_id' => '', 'is_paid' => false];

    protected $validationAttributes = [
        'extension.extension_id' => 'Hours',
    ];

    public function search()
    {
        $this->validate([
            'searchQuery' => 'required'
        ]);
        switch ($this->searhMode) {
            case 'qr_code':
                $this->search_by_qr_code();
                break;
            case 'room':
                $this->guest = Guest::query()
                    ->whereHas('check_in_details', function ($query) {
                        return $query->whereHas('room', function ($query) {
                            return $query->where('number', $this->searchQuery);
                        });
                    })
                    ->where('is_checked_in', 1)
                    ->first();
                break;
        }
    }

    public function search_by_qr_code()
    {
        $guest_exists = Guest::query()
            ->where($this->searhMode, $this->searchQuery)
            ->where('is_checked_in', 1)
            ->where('totaly_checked_out', 0)
            ->first();

        if ($guest_exists) {
            $this->guest = $guest_exists;
        } else {
            $this->notification()->error(
                $title = 'Guest not found',
                $description = 'Guest may not be checked in or may be already checked out.'
            );
            $this->guest = null;
        }
    }

    public function clear()
    {
        $this->guest = null;
        $this->searchQuery = '';
    }

    public function extend_hours()
    {
        $this->validate([
            'extension.extension_id' => 'required'
        ]);
        DB::beginTransaction();
        $extension = Extension::find($this->extension['extension_id']);
        $this->guest->transactions()->create([
            'branch_id' => auth()->user()->branch_id,
            'transaction_type_id' => 6,
            'payable_amount' => $extension->amount,
            'paid_at' => $this->extension['is_paid'] == true ? now() : null,
        ]);
        $check_in_detail = $this->guest->transactions()->where('transaction_type_id', 1)->first()->check_in_detail;
        $check_in_detail->update([
            'expected_check_out_at' => Carbon::parse($check_in_detail->expected_check_out_at)->addHours($extension->hours),
        ]);
        $check_in_detail->extensions()->attach($extension->id);
        DB::commit();

        $this->notification()->success(
            $title = 'Success',
            $description = 'Hours extended successfully.'
        );
        $this->showExtendModal = false;
        $this->reset('extension');
    }

    public function mount()
    {
        $this->extensions = auth()->user()->branch->extensions;
    }

    public function change_room()
    {
        DB::beginTransaction();
       

      
        DB::commit();
        $this->showChangeRoomModal = true;
    }

    public function render()
    {
        
        return view('livewire.front-desk.transactions', [
            'transactions' => $this->guest ?
                Transaction::query()
                ->where('guest_id', $this->guest->id)
                ->orderBy('created_at', 'desc')
                ->with('transaction_type')
                ->get()
                : [],
            'check_in_detail' => $this->guest ? $this->guest->transactions()->where('transaction_type_id', 1)->first()->check_in_detail : null,
            'damages' => $this->guest ?
                Damage::where('guest_id', $this->guest->id)
                ->orderBy('created_at', 'desc')
                ->with('hotel_item')
                ->get()
                : [],
        ]);
    }
}
