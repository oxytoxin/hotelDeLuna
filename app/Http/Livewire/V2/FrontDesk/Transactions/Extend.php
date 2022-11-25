<?php

namespace App\Http\Livewire\V2\FrontDesk\Transactions;

use App\Http\Livewire\FrontDesk\CheckIn;
use Livewire\Component;

use Carbon\Carbon;
use App\Models\Extension;
use App\Models\Transaction;
use App\Models\CheckInDetail;
use App\Models\ExtensionCapping;
use Illuminate\Support\Facades\DB;
use App\Models\StayExtension;
use App\Models\Rate;
use App\Models\StayingHour;
use App\Traits\{WithCaching};

class Extend extends Component
{
    use WithCaching;

    public $guestId;

    public $unableToProceed = false;

    public $checkInDetailId;

    public $checkInDetailRoomId,$checkInDetailRoomTypeId,$checkInDetailRoomRateId,$checkInDetailRoomRateAmount,$checkInDetailRoomRateStayingHour,$checkInDetailStaticHourStayed,$checkInDetailExpectedCheckOutAt;

    public $branchResettingTime,$resettingTimeRateAmount;

    public $extensionRates = [];

    public $actionUnavailable = false;

    public $extensionHour,$extensionAmount;

    protected $listeners = ['confirmExtension','payTransaction','depositDeducted'=>'$refresh'];

    public function payWithDeposit($transaction_id,$payable_amount)
    {
        $this->emit('payWithDeposit',[
            'guest_id' => $this->guestId,
            'transaction_id' => $transaction_id,
            'payable_amount' => $payable_amount
        ]);
    }
    public function payTransaction(Transaction $transaction)
    {
        $transaction->update([
            'paid_at' => Carbon::now(),
        ]);
        $this->emit('transactionUpdated');

        $this->dispatchBrowserEvent('notify-alert', [
            'type' => 'success',
            'title' => 'Transaction Paid',
            'message' => 'Transaction has been paid'
        ]);
    }

    public function mount()
    {
       $this->extensionRates = Extension::where('branch_id', auth()->user()->branch_id)->get();
       if(count($this->extensionRates) == 0){
           $this->actionUnavailable = true;
           return;
       }

       $extension_capping = ExtensionCapping::where('branch_id', auth()->user()->branch_id)->first();
       if($extension_capping == null){
            $this->actionUnavailable = true;
            return;
       }else{
              $this->branchResettingTime = $extension_capping->hours;
              $rateForResettingTime =  Rate::where('branch_id', auth()->user()->branch_id)
              ->whereHas('staying_hour', function ($query) {
                  $query->where('number', $this->branchResettingTime);
              })->first();

              if ($rateForResettingTime == null) {
                    $this->actionUnavailable = true;
                    return;
              }
              $this->resettingTimeRateAmount = $rateForResettingTime->amount;
       }

    }

    public function updatedExtensionHour()
    {
        DB::beginTransaction();
        $extensionRate = $this->extensionRates->find($this->extensionHour);

        // to get the sum of hours extended by the guest
        $extensionHistory = StayExtension::where('guest_id',$this->guestId);
        $totalExtensionHours = $extensionHistory->sum('hours');
        $totalHours = $this->checkInDetailStaticHourStayed + $totalExtensionHours;

        $resetHours = StayingHour::where('branch_id', auth()->user()->branch_id)
            ->where('number', '>=', $extensionRate->hours)
            ->orderBy('number', 'ASC')
            ->first()->rates()->where('type_id', $this->checkInDetailRoomTypeId)->first()->amount;

        if ($totalHours % $this->branchResettingTime == 0) {
            if ($extensionRate->hours < $this->branchResettingTime) {
                $this->extensionAmount = $resetHours;
            } else {
                $days = floor($extensionRate->hours / $this->branchResettingTime);
                $hours = $extensionRate->hours % $this->branchResettingTime;
                $dailyAmount = $this->resettingTimeRateAmount * $days;
                $hourlyRateAmount = $hours > 0 ? Rate::where('type_id', $this->checkInDetailRoomTypeId)
                    ->whereHas('staying_hour', function ($query) use ($hours) {
                        $query->where('number', '>=', $hours);
                    })->first()->amount : 0;
                $totalExtendAmount = StayExtension::whereHas('transaction', function ($query) {
                    $query->where('guest_id', $this->guestId);
                })->sum('amount');
                $totalCheckedInAmountAndExtensionAmount = $this->checkInDetailRoomRateAmount + $totalExtendAmount;
                $total_amount = $dailyAmount + $hourlyRateAmount;
                $this->extensionAmount =  $total_amount - $totalCheckedInAmountAndExtensionAmount;
            }
        } else {
            if ($extensionRate->hours + $totalHours <= $this->branchResettingTime) {
                $this->extensionAmount =  $extensionRate->amount;
            } else {
                $temp_total = $extensionRate->hours + $totalHours;
                $days = floor($temp_total / $this->branchResettingTime);
                $hours = $temp_total % $this->branchResettingTime;
                $dailyAmount = $this->resettingTimeRateAmount * $days;
                $hourlyRateAmount =  $hours > 0 ? Rate::where('type_id', $this->checkInDetailRoomTypeId)
                    ->whereHas('staying_hour', function ($query) use ($hours) {
                        $query->where('number', '>=', $hours);
                    })->first()->amount : 0;
                $totalExtendAmount = StayExtension::where('guest_id', $this->guestId)->sum('amount');

                $totalCheckedInAmountAndExtensionAmount = $this->checkInDetailRoomRateAmount + $totalExtendAmount;
                $total_amount = $dailyAmount + $hourlyRateAmount;
                $this->extensionAmount =  $total_amount - $totalCheckedInAmountAndExtensionAmount;
            }
        }
        DB::commit();
    }

    public function confirmExtension()
    {
        $this->validate([
            'extensionHour' => 'required',
        ]);

        DB::beginTransaction();
        $extensionHours = $this->extensionRates->find($this->extensionHour)->hours;
        $extension_transaction = Transaction::create([
            'guest_id' => $this->guestId,
            'branch_id' => auth()->user()->branch_id,
            'transaction_type_id' => 6,
            'payable_amount' => $this->extensionAmount,
            'room_id' => $this->checkInDetailRoomId,
            'remarks' => 'Guest extended his/her stay for ' . $extensionHours . ' hours',
            'front_desk_name' => auth()->user()->name,
            'user_id' => auth()->user()->id,
        ]);
        StayExtension::create([
            'guest_id' => $this->guestId,
            'extension_id' => $this->extensionHour,
            'hours' => $extensionHours,
            'amount' => $this->extensionAmount,
            'front_desk_name' => auth()->user()->name,
            'user_id' => auth()->user()->id,
        ]);

        CheckInDetail::where('guest_id', $this->guestId)->update([
            'expected_check_out_at' => Carbon::parse($this->checkInDetailExpectedCheckOutAt)->addHours($extensionHours)
        ]);

        DB::commit();

        $this->extensionHour = "";
        $this->extensionAmount = "";

        $this->emit('transactionUpdated');

        $this->dispatchBrowserEvent('close-form');

        $this->dispatchBrowserEvent('notify-alert', [
            'type' => 'success',
            'title' => 'Success',
            'message' => 'Guest stay extended successfully!'
        ]);
    }


    public function getTransactionsQueryProperty()
    {
        return Transaction::where('guest_id', $this->guestId)->where('transaction_type_id', 6);
    }
    
    public function getTransactionsProperty()
    {
        return $this->cache(function () {
            return $this->transactionsQuery->get();
        });
    }

    public function render()
    {
        return view('livewire.v2.front-desk.transactions.extend',[
            'transactions' => $this->transactions,
        ]);
    }
}
