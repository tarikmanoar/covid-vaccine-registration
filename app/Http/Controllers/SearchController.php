<?php

namespace App\Http\Controllers;

use App\Http\Requests\SearchRequest;
use App\Models\User;

class SearchController extends Controller
{
    public function index()
    {
        return view('search.index');
    }

    public function results(SearchRequest $request)
    {
        $request->validated();
        $user = User::select(['id', 'nid', 'name'])
            ->where('nid', $request->nid)
            ->with(['vaccinations' => function ($query) {
                $query->select('id', 'user_id', 'center_id', 'date', 'doze', 'status')
                    ->with(['center:id,name,address']);
            }])
            ->first();
        $vaccinations = $user ? $user->vaccinations : collect();

        return view('search.results', compact('user', 'vaccinations'));
    }
}
