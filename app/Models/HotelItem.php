<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HotelItem extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function damages()
    {
        return $this->hasMany(Damage::class);
    }
}
