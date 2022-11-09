<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomTransactionLog extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function checkInDetail()
    {
        return $this->belongsTo(CheckInDetail::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}
