<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DoctorMeta extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'days',
        'start_time',
        'end_time',
        'check_time_duration',
        'fees',
        'stripe_account_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
