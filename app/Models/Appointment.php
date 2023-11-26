<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'doctor_id',
        'client_id',
        'appointment_time',
        'appointment_date',
        'status'
    ];

    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function payment()
    {
        return $this->belongsTo(TransactionHistory::class ,'id', 'appointment_id' )->withDefault();
    }

}
