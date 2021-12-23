<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;

class BillsController extends Controller
{
    public function index()
    {
        return Inertia::render('Bills/Index', [
            'filters' => Request::all('search', 'trashed'),
            'bills' => Auth::user()->account->bills()
                ->orderBy('name')
//                ->filter(Request::only('search', 'trashed'))
                ->paginate(10)
                ->withQueryString()
                ->through(fn ($bill) => [
                    'id' => $bill->id,
                    'number' => $bill->bill_number,
                    'amount' => $bill->amount,
//                    'deleted_at' => $bill->deleted_at,
                ]),
        ]);
    }
}
