<?php

namespace App\Http\Controllers;

use App\Http\Requests\VaccinationStoreRequest;
use App\Models\VaccineCenter;
use App\Models\VaccineRegistration;
use App\Services\VaccinationService;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

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
    public function store(VaccinationStoreRequest $request)
    {
        $validatedData = $request->validated();

        try {
            $result = app(VaccinationService::class)->store($validatedData);

            return to_route('dashboard')->with('success', $result['message']);
        } catch (ValidationException $e) {
            return back()->withErrors($e->validator)->withInput();
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
