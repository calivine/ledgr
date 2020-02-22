<?php

namespace App\Http\Controllers;

use App\Actions\Budget\StoreCategory;
use App\Actions\Budget\StorePlanned;
use App\Actions\Budget\GetBudget;
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
        // Get Budget Items Where Period = F and Year = Y
        $response = new GetBudget(Auth::user());
        $budget = $response->budget;

        $budget_period = date('F') . " " . date('Y');

        return view('budget.index')->with([
            'budget' => $budget,
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
        $action = new StorePlanned($request);

        return response()->json([
            'planned' => $action->rda['planned']
        ]);
    }


    /*
     * POST
     * /budget/category/new
     * Add New Category To Budget Sheet
     */
    public function createCategory(Request $request)
    {
        $action = new StoreCategory($request);

        return response()->json([
            'planned' => $action->rda['planned'],
            'category' => $action->rda['category']
        ]);
    }

}
