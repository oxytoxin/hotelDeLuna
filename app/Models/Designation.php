<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Designation extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function room_boy()
    {
        return $this->belongsTo(RoomBoy::class);
    }
    public function floor()
    {
        return $this->belongsTo(Floor::class);
    }
}
