<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cleaning extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function room_boy()
    {
        return $this->belongsTo(RoomBoy::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }
}
