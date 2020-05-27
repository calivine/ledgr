<?php

namespace App\Http\Controllers;

use App\Actions\Budget\StoreBudget;
use App\Actions\Budget\StoreCategory;
use App\Actions\Budget\UpdatePlanned;
use App\Budget;
use App\Budget\BudgetSheet;
use App\Events\IconWasChanged;
use App\Events\PlannedBudgetChanged;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * Handles requests related to monthly budget data
 *
 * @category   Controllers
 *
 * @author     Alex Caloggero
 */
class BudgetController extends Controller
{
    /*
     * GET
     * /budget
     * Returns Monthly Budget Sheet
     */
    public function index()
    {
        $icons = DB::table('icons')->get();

        $response = new BudgetSheet(Auth::user()->id);

        // If Budget sheet doesn't exist, create a new one.
        if (sizeof($response->budget) == 0)
        {
            new StoreBudget(Auth::user());
            $response = new BudgetSheet(Auth::user()->id);
        }

        $budget_period = date('F') . " " . date('Y');

        return view('budget.index')->with([
            'budget' => $response->budget,
            'period' => $budget_period,
            'icons' => $icons
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

        $id = $request->input('id');
        $planned = $request->input('new_value');

        event(new PlannedBudgetChanged($id, $planned));
        // $action = new UpdatePlanned($request->input('id'), $request->input('new_value'));

        return response()->json([
            'planned' => $planned
        ]);
    }

    /*
     * POST
     * /budget/icon/update
     * Updates Icon
     * argument     Number ID
     * argument     String Icon description
     */
    public function updateIcon(Request $request)
    {
        $request->validate([
            'icon' => 'required|string'
        ]);

        event(new IconWasChanged($request->input('id'), $request->input('icon')));

        return response()->json([
            'id' => $request->input('id'),
            'icon' => $request->input('icon')
        ]);

    }



    /*
     * POST
     * /budget/category/new
     * Add New Category To Budget Sheet
     */
    public function createCategory(Request $request)
    {
        Log::info("Attempting to add new category.");
        $request->validate([
            'category' => 'required|string',
            'planned' => 'required|numeric'
        ]);

        $action = new StoreCategory($request);

        return redirect(route('budget'));
    }


    /*
     * GET
     * /budget/setup
     * New User Budget Setup Page
     */
    public function newBudgetSetup(Request $request)
    {
        $response = new BudgetSheet(Auth::user()->id);
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
