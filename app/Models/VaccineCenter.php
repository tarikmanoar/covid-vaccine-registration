<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VaccineCenter extends Model
{
    /** @use HasFactory<\Database\Factories\VaccineCenterFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'name',
        'phone',
        'email',
        'url',
        'address',
        'city',
        'state',
        'zip',
        'latitude',
        'longitude',
        'hours',
        'daily_limit',
        'notes',
    ];
}
