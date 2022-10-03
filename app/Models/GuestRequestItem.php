<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GuestRequestItem extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function guest()
    {
        return $this->belongsTo(Guest::class);
    }
    public function requestable_item()
    {
        return $this->belongsTo(RequestableItem::class);
    }
}
