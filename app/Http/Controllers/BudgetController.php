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

    /*
     * POST
     * /budget/planned/update
     * Updates Planned Amount For Budget Category
     */
    public function updatePlanned(Request $request)
    {
        $new_planned = $request->input('new_value');
        $period = $request->input('budget_period');
        $category = $request->input('category');

        $p = $new_planned;
        // TODO: Save New Planned Budget Value To Budget Table

        return response()->json([
            'planned' => $p
        ]);
    }
}
