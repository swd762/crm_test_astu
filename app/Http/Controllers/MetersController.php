<?php

namespace App\Http\Controllers;

use App\Models\Meter;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;

class MetersController extends Controller
{
    public function index()
    {
        return Inertia::render('Meters/Index', [
            'filters' => \Illuminate\Support\Facades\Request::all('search', 'trashed'),
            'meters' => Auth::user()->account->meters()
                ->orderBy('created_at', 'desc')
//                ->filter(Request::only('search', 'trashed'))
                ->paginate(10)
                ->withQueryString()
                ->through(fn($meter) => [
                    'id' => $meter->id,
                    'meters_previous' => $meter->meters_previous,
                    'meters_last' => $meter->meters_last,
                    'date' => Carbon::parse($meter->created_at)->toDateString(),
                ]),
        ]);
    }

    public function create()
    {
        $lastMeters = Meter::select('meters_last')->latest()->first();
        return Inertia::render('Meters/Create', [
            'meters_last' => $lastMeters->meters_last
        ]);
    }

    public function store()
    {
        Auth::user()->account->meters()->create(
            Request::validate([
                'meters_previous' => ['required', 'integer'],
                'meters_last' => ['required', 'integer', 'gt:meters_previous']
            ])
        );

        return Redirect::route('meters')->with('success', 'Meters created');
    }

    public function edit(Meter $meter)
    {
//        return Inertia::render()
    }
}
