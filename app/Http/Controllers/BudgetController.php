<?php

namespace App\Http\Controllers;
use App\Budget;

use Illuminate\Http\Request;

class BudgetController extends Controller
{
    /*
     * GET
     * /budget
     * Returns Monthly Budget Sheet
     */
    public function index()
    {

        $response = Budget::all();

        return view('budget.index')->with([
            'budget' => $response
        ]);
    }
}
