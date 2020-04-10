<?php

namespace App\Http\Controllers;

use App\Actions\Budget\StoreBudget;
use App\Actions\Budget\StoreCategory;
use App\Actions\Budget\UpdatePlanned;
use App\Actions\Budget\GetBudget;
use App\Actions\Utility\DateUtility;
use App\Budget;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Arr;

class BudgetController extends Controller
{
    /*
     * GET
     * /budget
     * Returns Monthly Budget Sheet
     */
    public function index()
    {
        $response = new GetBudget(Auth::user());

        // If Budget sheet doesn't exist, create a new one.
        if (sizeof($response->budget) == 0)
        {
            new StoreBudget(Auth::user());
            $response = new GetBudget(Auth::user());
        }

        $budget_period = date('F') . " " . date('Y');

        return view('budget.index')->with([
            'budget' => $response->budget,
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
        $request->validate([
            'new_value' => 'required|numeric'
        ]);

        $action = new UpdatePlanned($request->input('id'), $request->input('new_value'));

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
        $request->validate([
            'name' => 'required|string',
            'planned' => 'required|numeric'
        ]);

        $action = new StoreCategory($request);

        return response()->json([
            'planned' => $action->rda['planned'],
            'category' => $action->rda['category']
        ]);
    }


    /*
     * GET
     * /budget/setup
     * New User Budget Setup Page
     */

    public function newBudgetSetup(Request $request)
    {
        $response = new GetBudget(Auth::user());
        return view('budget.setup')->with([
            'budget' => $response->budget
        ]);

    }

    /*
     * POST
     * /budget/setup/new
     * Process new budget planned values
     */
    public function budgetSetup(Request $request)
    {
        $new_budget = $request->all();

        // Remove token.
        Arr::pull($new_budget, '_token');

        foreach($new_budget as $index => $category) {
            new UpdatePlanned($index, $category);
            // $budget = Budget::find($index);
            // $budget->planned = $category;
            // $budget->save();

        }

        return redirect(route('dashboard'));

    }

}
