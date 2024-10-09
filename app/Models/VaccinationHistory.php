<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VaccinationHistory extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'vaccine_id',
        'status',
        'note',
    ];

    /**
     * Get the vaccine registration record associated with the history.
     */
    public function registration()
    {
        return $this->belongsTo(VaccineRegistration::class, 'vaccine_id');
    }
}
