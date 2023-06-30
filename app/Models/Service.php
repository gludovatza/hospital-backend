<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'length', 'price'
    ];

    public function appointments()
    {
        return $this->hasMany('App\Models\Appointment');
    }
}
