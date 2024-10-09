<?php

namespace App\Http\Controllers;

class DashboardController extends Controller
{
    public function index()
    {
        $vaccinations = auth()->user()->vaccinations()->with(['center:id,name,address', 'histories'])->latest()->get()->groupBy('doze');

        return view('dashboard', compact('vaccinations'));
    }
}
