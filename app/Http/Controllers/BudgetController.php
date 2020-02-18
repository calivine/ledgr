<?php

namespace App\Http\Controllers;

use App\Budget;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BudgetController extends Controller
{
    /*
     * GET
     * /budget
     * Returns Monthly Budget Sheet
     */
    public function index()
    {
        // Get Current User ID
        $id = Auth::id();

        // Get Budget Items Where Period = F and Year = Y
        $response = Budget::where([
            ['year', '=', date('Y')],
            ['period', '=', date('F')],
            ['user_id', '=', $id]
        ])->get();

        if ($response->isEmpty()) {
            // Generate New Budget Sheet
            $date = date('Y');
            $period = date('F');

            $user = Auth::user();

            $json = file_get_contents('../database/budget.json');
            $json_data = json_decode($json, true);

            foreach($json_data['data'] as $budget) {
                $new_budget = new Budget;

                $new_budget->category = $budget['category'];
                $new_budget->year = $date;
                $new_budget->period = $period;

                $new_budget->user()->associate($user);

                $new_budget->save();
            }

            $response = Budget::where([
                ['year', '=', $date],
                ['period', '=', $period],
                ['user_id', '=', $id]
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


    /*
     * POST
     * /budget/category/new
     * Add New Category To Budget Sheet
     */
    public function createCategory(Request $request)
    {
        $user = $request->user();
        $new_category = $request->input('name');
        $new_planned_budget = $request->input('planned');
        $category = new Budget;
        $category->category = $new_category;
        $category->planned = $new_planned_budget;
        $category->year = date('Y');
        $category->period = date('F');
        $category->user()->associate($user);

        $category->save();

        return response()->json([
            'planned' => $new_planned_budget,
            'category' => $new_category
        ]);
    }

}
