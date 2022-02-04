<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Bill;
use App\Models\Meter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class BillsController extends Controller
{

    /**
     * Список счетов текущего пользователя
     *
     * @return \Inertia\Response
     */
    public function index()
    {
        return Inertia::render('Bills/Index', [
            'filters' => \Illuminate\Support\Facades\Request::all('search', 'trashed'),
            'bills' => Auth::user()->account->bills()
//                ->orderBy('name')
//                ->filter(Request::only('search', 'trashed'))
                ->paginate(10)
                ->withQueryString()
                ->through(function ($bill) {
                    return [
                        'id' => $bill->id,
                        'amount' => $bill->amount,
                        'is_paid' => $bill->is_paid,
                        'created_at' => $bill->created_at
                    ];
                }),
        ]);
    }

    /**
     * Создать счет по выбранным показаниям
     *
     * @param Meter $meter
     * @return \Inertia\Response
     */
    public function createFromMeters(Meter $meter)
    {
        return Inertia::render('Bills/CreateFromMeters', [
            'meters' => $meter
        ]);
    }

    /**
     * Сохранить созданный из показаний счет
     *
     * @param Meter $meter
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeFromMeters(Meter $meter, Request $request)
    {
        $account = Account::where('id', $meter->account_id)->first();
        $account->bills()->create([
            'account_id' => $account->id,
            'amount' => $request->amount
        ]);

        return Redirect::route('abonents.meters', $meter->account_id)->with('success', 'Счет создан');
    }

    /**
     * Удаление счета из списка абонента
     *
     * @param Account $account
     * @param Bill $bill
     * @return \Illuminate\Http\RedirectResponse
     */
    public function abonentBillsDelete(Account $account, Bill $bill)
    {
        $bill->delete();
        return Redirect::route('abonents.bills', $account->id)->with('success', 'Счет удален');
    }

    /**
     * Создание произвольного счета
     *
     * @param Account $account
     * @return \Inertia\Response
     */
    public function create(Account $account)
    {
        return Inertia::render('Bills/Create', [
            'account' => $account
        ]);
    }

    /**
     * Сохранение произвольного счета
     *
     * @param Account $account
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Account $account, Request $request)
    {
        $account->bills()->create([
            'account_id' => $account->id,
            'amount' => $request->amount
        ]);

        return Redirect::route('abonents.bills', $account->id)->with('success', 'Счет создан');
    }
}
