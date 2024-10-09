<?php

namespace App\Services;

use App\Models\VaccineCenter;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class VaccinationService
{
    public function store(array $validatedData)
    {
        $user = Auth::user();
        $center = VaccineCenter::findOrFail($validatedData['center_id']);

        $userVaccinations = $user->vaccinations()
            ->where(function ($query) use ($validatedData) {
                $query->where('date', $validatedData['date'])
                    ->orWhere('doze', $validatedData['doze']);
            })
            ->orderBy('date', 'desc')
            ->get();

        $this->checkAvailability($center, $validatedData, $userVaccinations);

        try {
            $vaccine = $user->vaccinations()->create([
                'center_id' => $validatedData['center_id'],
                'date' => $validatedData['date'],
                'doze' => $validatedData['doze'],
                'status' => 'Not scheduled',
            ]);

            $vaccine->histories()->create([
                'status' => 'Pending',
                'note' => "Applied for {$validatedData['doze']} vaccination",
            ]);

            return ['status' => 'success', 'message' => 'Successfully registered for vaccination'];
        } catch (\Exception $e) {
            throw ValidationException::withMessages(['error' => 'Failed to register for vaccination']);
        }
    }

    protected function checkAvailability($center, $validatedData, $userVaccinations)
    {
        if ($center->vaccineRegistrations()->where('date', $validatedData['date'])->count() >= $center->capacity) {
            throw ValidationException::withMessages(['error' => 'No available slot for this date']);
        }

        if ($userVaccinations->where('status', 'Vaccinated')->count() >= 4) {
            throw ValidationException::withMessages(['error' => 'You have already been vaccinated for all doses']);
        }

        if ($userVaccinations->count() == 0 && $validatedData['doze'] !== '1st') {
            throw ValidationException::withMessages(['error' => 'You have to start with 1st dose']);
        }

        if ($userVaccinations->count() > 0) {
            $lastVaccination = $userVaccinations->first();
            if ($lastVaccination->status !== 'Vaccinated' && $lastVaccination->doze !== $validatedData['doze']) {
                throw ValidationException::withMessages(['error' => 'You need to complete the previous dose before registering for another']);
            }
        }

        if ($userVaccinations->where('date', $validatedData['date'])->first()) {
            throw ValidationException::withMessages(['error' => 'You have already registered for vaccination on this date']);
        }

        $scheduledDoze = $userVaccinations->where('doze', $validatedData['doze'])->first();

        if ($scheduledDoze) {
            if ($scheduledDoze->status === 'Scheduled') {
                throw ValidationException::withMessages(['error' => 'You have already scheduled this dose']);
            }
            if ($scheduledDoze->status === 'Vaccinated') {
                throw ValidationException::withMessages(['error' => 'You have already been vaccinated for this dose']);
            }
            throw ValidationException::withMessages(['error' => 'You have already registered for this dose']);
        }
    }
}
