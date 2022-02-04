<?php

namespace App\Http\Controllers;

use App\Models\Meter;
use Carbon\Carbon;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;


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
            'filters' => \Illuminate\Support\Facades\Request::all('search', 'trashed'),
            'meters' => Auth::user()->account->meters()
                ->orderBy('created_at', 'desc')
//                ->filter(Request::only('search', 'trashed'))
                ->paginate(10)
                ->withQueryString()
                ->through(fn($meter) => [
                    'id' => $meter->id,
                    'previous' => $meter->previous,
                    'last' => $meter->last,
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
        $lastMeters = Meter::orderBy('last', 'desc')->where('account_id', Auth::user()->account->id)->first();
        return Inertia::render('Meters/Create', [
            'last' => $lastMeters->last
        ]);
    }

    /**
     * Сохранить созданные показания текущего пользователя
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $meters = new Meter();
        $meters->previous = $request->previous;
        $meters->last = $request->last;
        $meters->account_id = Auth::user()->account->id;
        $meters->save();

        return Redirect::route('meters')->with('success', 'Показания созданы');
    }

    /**
     * Редактирование показаний текущего пользователя
     *
     * @param Meter $meter
     * @return \Inertia\Response
     */
    public function edit(Meter $meter, Request $request)
    {
        return Inertia::render('Meters/Edit', [
            'meters' => [
                'id' => $meter->id,
                'previous' => $meter->previous,
                'last' => $meter->last,
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
    public function update(Meter $meter, Request $request)
    {
        $this->validate($request, [
            'last' => ['required', 'numeric'],
            'previous' => ['required', 'numeric'],
        ]);
        $meter->last = $request->last;
        $meter->previous = $request->previous;
        $meter->save();

        return Redirect::route('meters')->with('success', 'Показания обновлены');
    }
}
