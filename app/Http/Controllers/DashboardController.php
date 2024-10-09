<?php

namespace App\Http\Controllers;

class DashboardController extends Controller
{
    public function index()
    {
        $vaccination = auth()->user()->vaccinations;

        return view('dashboard', compact('vaccination'));
    }
}
