<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function floor()
    {
        return $this->belongsTo(Floor::class);
    }

    public function room_status()
    {
        return $this->belongsTo(RoomStatus::class);
    }

    public function type()
    {
        return $this->belongsTo(Type::class);
    }

    public function check_in_details()
    {
        return $this->hasMany(CheckInDetail::class);
    }

    public function room_boys()
    {
        return $this->hasMany(RoomBoy::class);
    }

    public function damages()
    {
        return $this->hasMany(Damages::class);
    }
}
