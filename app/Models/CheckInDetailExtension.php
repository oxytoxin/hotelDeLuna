<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CheckInDetailExtension extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function check_in_detail()
    {
        return $this->belongsTo(CheckInDetail::class);
    }

    public function extension()
    {
        return $this->belongsTo(Extension::class);
    }
}
