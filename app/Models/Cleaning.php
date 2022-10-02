<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cleaning extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function roomboy(){
        return $this->belongsTo(RoomBoy::class);
    }

    public function room(){
        return $this->belongsTo(Room::class);
    }
}
