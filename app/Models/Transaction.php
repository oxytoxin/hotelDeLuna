<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $guarded = [];
    
    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function guest()
    {
        return $this->belongsTo(Guest::class);
    }

    public function check_in_detail()
    {
        return $this->hasOne(CheckInDetail::class);
    }

    public function transaction_type()
    {
        return $this->belongsTo(TransactionType::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function discounts()
    {
        return $this->belongsToMany(TransactionDiscount::class);
    }

    public function room_change()
    {
        return $this->hasOne(RoomChange::class);
    }

    public function check_in_detail_extensions()
    {
        return $this->hasOne(CheckInDetailExtension::class);
    }

    public function damage()
    {
        return $this->hasOne(Damage::class);
    }

    public function guest_request_item()
    {
        return $this->hasOne(GuestRequestItem::class);
    }
    
    public function deposit()
    {
        return $this->hasOne(Deposit::class);
    }
}
