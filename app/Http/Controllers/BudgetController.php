<?php

namespace App\Http\Controllers;

use App\Actions\Budget\DestroyBudget;
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
use Illuminate\Support\Str;

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
        // Retrieve User
        $user = Auth::user();
        $id = $user->id;
        $theme = $user->theme;

        $icons = DB::table('icons')->get();

        $iconsDisplay = [];
        foreach($icons as $icon) {
            // $iconsDisplay[] = Str::studly($icon->text);
            $iconsDisplay[] = $icon->text;
        }
        $iconsdisplay = array_map('Str::studly', $iconsDisplay);
        // Log::info($iconsdisplay);

        $response = new BudgetSheet($id);

        // If Budget sheet doesn't exist, create a new one.
        if (sizeof($response->budget) == 0)
        {
            new StoreBudget($user);
            $response = new BudgetSheet($id);
        }

        $budget_period = date('F') . " " . date('Y');

        return view('content.budget.index')->with([
            'budget' => $response->budget,
            'month' => $budget_period,
            'icons' => $icons,
            'theme' => $theme
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

        $user = $request->user();

        $new_category = $request->input('category');
        $new_planned_budget = $request->input('planned');

        $action = new StoreCategory($new_category, $new_planned_budget, $user);

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
        return view('content.budget.setup')->with([
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

    /**
     * GET
     * /budget/{id}/delete
     * Display confirm budget delete page.
     */
     public function deleteBudget($id)
     {
          return view('content.budget.delete')->with([
              'id' => $id
          ]);
     }

     /**
      * POST
      * /transaction/{id}/destroy
      * Delete transaction.
      */
      public function destroyBudget($id)
      {
          new DestroyBudget($id);

          return redirect()->route('budget')->with(['alert' => 'Budget Category Was Deleted']);

      }


}
