<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Extension extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function check_in_details()
    {
        return $this->belongsToMany(CheckInDetail::class);
    }
    
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}
