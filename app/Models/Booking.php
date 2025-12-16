<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $guarded = [];

    // Relasi: Booking milik User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi: Booking milik Service
    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
