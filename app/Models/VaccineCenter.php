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
        'capacity',
        'notes',
    ];

    /**
     * Get the vaccine registration records associated with the vaccine center.
     */
    public function vaccineRegistrations()
    {
        return $this->hasMany(VaccineRegistration::class, 'center_id');
    }
}
