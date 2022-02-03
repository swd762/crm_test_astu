<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Bill;
use App\Models\User;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;

class AbonentsController extends Controller
{
    //
    public function index()
    {
        return Inertia::render('Abonents/Index', [
            'filters' => Request::all('search', 'trashed'),
            'abonents' => User::with('account')
                ->paginate(10)
                ->withQueryString()
//            ->throught(fn($user) => [
//                'id'=>$user->id,
//                'last_name' => $user->last_name,
//
//            ])

        ]);
    }

    public function abonentMeters(Account $account)
    {
        return Inertia::render('Abonents/Meters', [
            'filters' => Request::all('search', 'trashed'),
            'account' => $account,
            'meters' => $account->meters()
                ->orderBy('created_at', 'desc')
//                ->filter(Request::only('search', 'trashed'))
                ->paginate(10)
                ->withQueryString()
                ->through(function ($meter) {
                    return [
                        'id' => $meter->id,
                        'meters_previous' => $meter->previous,
                        'meters_last' => $meter->last,
                        'date' => Carbon::parse($meter->created_at)->toDateString(),
                    ];
                }),
        ]);
    }

    public function abonentBills(Account $account)
    {
        return Inertia::render('Abonents/Bills', [
            'filters' => Request::all('search', 'trashed'),
            'account' => $account,
            'bills' => $account->bills()
                ->orderBy('created_at', 'desc')
//                ->filter(Request::only('search', 'trashed'))
                ->paginate(10)
                ->withQueryString()
                ->through(function ($bill) {
                    return [
                        'id' => $bill->id,
                        'amount' => $bill->amount,
                        'is_paid'=>$bill->is_paid,
                        'created_at' =>$bill->created_at
                    ];
                }),
        ]);
    }


}
