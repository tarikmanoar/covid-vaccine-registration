<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index()
    {
        return view('search.index');
    }

    public function results(Request $request)
    {
        $request->validate([
            'nid' => ['required', 'string', 'regex:/^\d{10}$|^\d{13}$|^\d{17}$/', 'exists:'.User::class],
        ]);
        $user = User::where('nid', $request->nid)->first();
        $vaccinations = $user->vaccinations()->with(['center:id,name,address'])->get();

        return view('search.results', compact('user', 'vaccinations'));
    }
}
