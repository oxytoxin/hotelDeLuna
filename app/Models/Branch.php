<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function floors()
    {
        return $this->hasMany(Floor::class);
    }
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
    public function rates()
    {
        return $this->hasMany(Rate::class);
    }
    public function types()
    {
        return $this->hasMany(Type::class);
    }
}
