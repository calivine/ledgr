<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Income;

class IncomeController extends Controller
{
    /*
     * GET
     * /income/new
     * Display Form:
     * Add New Income Source
     */
    public function newIncome()
    {
        return view('content.income.index');
    }

    /*
     * POST
     * /income/
     * Process Input From New Income Form
     */
    public function storeIncome(Request $request)
    {
        $request->validate([
            'description' => 'required',
            'frequency' => 'required',
            'amount' => 'required'
        ]);

        $user = $request->user();

        $description = $request->input('description');
        $frequency = $request->input('frequency');
        $amount = $request->input('amount');

        $income = new Income;
        $income->description = $description;
        $income->frequency = $frequency;
        $income->amount = $amount;

        $income->user()->associate($user);

        $income->save();

        return redirect('income/new')->with([
            'alert' => 'New Income Added'
        ]);
    }
}
