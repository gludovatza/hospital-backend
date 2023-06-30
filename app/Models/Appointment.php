<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'date', 'employee_id', 'service_id'
    ];

    public function employee()
    {
        return $this->belongsTo('App\Models\Employee');
    }

    public function service()
    {
        return $this->belongsTo('App\Models\Service');
    }

    public function reservations()
    {
        return $this->hasMany('App\Models\Reservation');
    }
}
