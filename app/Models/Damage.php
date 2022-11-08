<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Damage extends Model
{
    use HasFactory;

    protected $guarded = [];

    // public function transaction()
    // {
    //     return $this->belongsTo(Transaction::class);
    // }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function hotel_item()
    {
        return $this->belongsTo(HotelItem::class);
    }

    public function guest()
    {
        return $this->belongsTo(Guest::class);
    }
}
