<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Guest extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function guest_request_items()
    {
        return $this->hasOne(GuestRequestItem::class);
    }

    public function foodAndBeverages()
    {
        return $this->hasMany(FoodAndBeverage::class);
    }

    public function amenities()
    {
        return $this->hasMany(Amenity::class);
    }

    public function damages()
    {
        return $this->hasMany(Damage::class);
    }

    public function deposits()
    {
        return $this->hasMany(Deposit::class);
    }

    public function roomChanges()
    {
        return $this->hasMany(RoomChange::class);
    }

    public function checkInDetail()
    {
        return $this->hasOne(CheckInDetail::class);
    }

    public function stayExtensions()
    {
        return $this->hasMany(StayExtension::class);
    }
}
