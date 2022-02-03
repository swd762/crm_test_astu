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
    /**
     * Список показаний текущего пользователя
     *
     * @return \Inertia\Response
     */
    public function index()
    {
        return Inertia::render('Meters/Index', [
            'filters' => Request::all('search', 'trashed'),
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

    /**
     * Создать новые показания текущего пользователя
     *
     * @return \Inertia\Response
     */
    public function create()
    {
        $lastMeters = Meter::select('meters_last')->latest()->first();
        return Inertia::render('Meters/Create', [
            'meters_last' => $lastMeters->meters_last
        ]);
    }

    /**
     * Сохранить созданные показания текущего пользователя
     *
     * @return \Illuminate\Http\RedirectResponse
     */
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

    /**
     * Редактирование показаний текущего пользователя
     *
     * @param Meter $meter
     * @return \Inertia\Response
     */
    public function edit(Meter $meter)
    {
        return Inertia::render('Meters/Edit', [
            'meters'=> [
                'id' => $meter->id,
                'meters_previous' => $meter->meters_previous,
                'meters_last' => $meter->meters_last,
                'date' => Carbon::parse($meter->created_at)->toDateString(),
            ]
        ]);
    }


    /**
     * Обновление показаний текущего пользователя
     *
     * @param Meter $meter
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Meter $meter)
    {
        $meter->update(
            Request::validate([
                'id'=>['required'],
                'meters_last' => ['required', 'numeric'],
                'meters_previous' => ['required', 'numeric'],
            ])
        );

        return Redirect::back()->with('success', 'meters updated');
    }
}
