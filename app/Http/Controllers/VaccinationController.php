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
            'date' => ['required', 'date', 'after:today'],
            'doze' => ['required', 'string', 'in:1st,2nd,3rd,4th'],
        ]);

        $center = VaccineCenter::findOrFail($validatedData['center_id']);
        $user = auth()->user();

        if ($center->vaccineRegistrations()->where('date', $validatedData['date'])->count() >= $center->capacity) {
            return back()->with('error', 'No available slot for this date');
        }

        if ($user->vaccinations()->where('status', 'Vaccinated')->count() >= 4) {
            return back()->with('error', 'You have already vaccinated for all dozes');
        }
        if ($user->vaccinations()->where('status', '!=', 'Vaccinated')->count()) {
            return back()->with('error', 'You have already registered for a vaccination');
        }

        $existingVaccinations = $user->vaccinations()->where('date', $validatedData['date'])->orWhere('doze', $validatedData['doze'])->get();

        foreach ($existingVaccinations as $vaccination) {
            if ($vaccination->date == $validatedData['date']) {
                return back()->with('error', 'You have already registered for vaccination on this date');
            }
            if ($vaccination->doze == $validatedData['doze']) {
                if ($vaccination->status == 'Scheduled') {
                    return back()->with('error', 'You have already scheduled for vaccination');
                }
                if ($vaccination->status == 'Vaccinated') {
                    return back()->with('error', 'You have already vaccinated');
                }

                return back()->with('error', 'You have already registered for this doze');
            }
        }

        try {
            $vaccine = $user->vaccinations()->create([
                'center_id' => $validatedData['center_id'],
                'date' => $validatedData['date'],
                'doze' => $validatedData['doze'],
                'status' => 'Not scheduled',
            ]);
            info('Vaccine registration created', ['vaccine' => $vaccine]);

            return to_route('dashboard')->with('success', 'Successfully registered for vaccination');
        } catch (\Exception $e) {
            return $e->getMessage();

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
