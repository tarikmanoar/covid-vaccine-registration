<?php

namespace App\Http\Controllers;

use App\Models\VaccineCenter;
use App\Models\VaccineRegistration;
use Illuminate\Http\Request;

class VaccinationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        abort(404);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $centers = VaccineCenter::all();

        return view('vaccination.create', compact('centers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'center_id' => ['required', 'integer', 'exists:vaccine_centers,id'],
            'date' => ['required', 'date', 'after:today', function ($attribute, $value, $fail) {
                $dayOfWeek = date('N', strtotime($value));
                if (in_array($dayOfWeek, [5, 6])) {//(Friday: 5, Saturday: 6)
                    $fail('The '.$attribute.' must be a weekday (Sunday to Thursday).');
                }
            }],
            'doze' => ['required', 'string', 'in:1st,2nd,3rd,4th'],
        ]);

        $user = auth()->user();
        $center = VaccineCenter::findOrFail($validatedData['center_id']);

        $userVaccinations = $user->vaccinations()
            ->where(function ($query) use ($validatedData) {
                $query->where('date', $validatedData['date'])
                    ->orWhere('doze', $validatedData['doze']);
            })
            ->orderBy('date', 'desc')
            ->get();

        $scheduledDoze = $userVaccinations->where('doze', $validatedData['doze'])->first();
        $existingDate = $userVaccinations->where('date', $validatedData['date'])->first();

        if ($center->vaccineRegistrations()->where('date', $validatedData['date'])->count() >= $center->capacity) {
            return back()->with('error', 'No available slot for this date');
        }

        if ($userVaccinations->where('status', 'Vaccinated')->count() >= 4) {
            return back()->with('error', 'You have already been vaccinated for all doses');
        }

        if ($userVaccinations->count() == 0 && $validatedData['doze'] !== '1st') {
            return back()->with('error', 'You have to start with 1st dose');
        }

        if ($userVaccinations->count() > 0) {
            $lastVaccination = $userVaccinations->first();
            if ($lastVaccination->status !== 'Vaccinated' && $lastVaccination->doze !== $validatedData['doze']) {
                return back()->with('error', 'You need to complete the previous dose before registering for another');
            }
        }

        if ($existingDate) {
            return back()->with('error', 'You have already registered for vaccination on this date');
        }

        if ($scheduledDoze) {
            if ($scheduledDoze->status === 'Scheduled') {
                return back()->with('error', 'You have already scheduled this dose');
            }
            if ($scheduledDoze->status === 'Vaccinated') {
                return back()->with('error', 'You have already been vaccinated for this dose');
            }

            return back()->with('error', 'You have already registered for this dose');
        }

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

            return to_route('dashboard')->with('success', 'Successfully registered for vaccination');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to register for vaccination');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(VaccineRegistration $vaccineRegistration)
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(VaccineRegistration $vaccineRegistration)
    {
        abort(404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, VaccineRegistration $vaccineRegistration)
    {
        abort(404);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(VaccineRegistration $vaccineRegistration)
    {
        abort(404);
    }
}
