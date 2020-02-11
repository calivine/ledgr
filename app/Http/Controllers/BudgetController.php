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
        // Get Budget Items Where Period = F and Year = Y
        //$response = Budget::all();

        $response = Budget::where([
            ['year', '=', date('Y')],
            ['period', '=', date('F')]
        ])->get();

        if ($response->isEmpty()) {
            // Generate New Budget Sheet
            $date = date('Y');
            $period = date('F');

            $json = file_get_contents('../database/budget.json');
            $json_data = json_decode($json, true);

            foreach($json_data['data'] as $budget) {
                $new_budget = new Budget;

                $new_budget->category = $budget['category'];
                $new_budget->year = $date;
                $new_budget->period = $period;

                $new_budget->save();
            }

            $response = Budget::where([
                ['year', '=', $date],
                ['period', '=', $period]
            ])->get();
        }

        $budget_period = date('F') . " " . date('Y');

        return view('budget.index')->with([
            'budget' => $response,
            'period' => $budget_period
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
        $id = $request->input('id');

        $budget = Budget::find($id);
        $budget->planned = $new_planned;
        $budget->save();

        return response()->json([
            'planned' => $new_planned
        ]);
    }
}
