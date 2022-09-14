<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
    public function guest()
    {
        return $this->belongsTo(Guest::class);
    }
    public function check_in_detail()
    {
        return $this->hasOne(CheckInDetail::class);
    }
    public function transaction_type()
    {
        return $this->belongsTo(TransactionType::class);
    }
    public function orders(){
        return $this->hasMany(Order::class);
    }
}
