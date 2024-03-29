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
use Facades\App\Repository\Budgets;
use Illuminate\Http\Request;
use Auth;
use Arr;
use DB;
use Log;
use Str;

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
    public function index(Request $request)
    {
        // Retrieve User
        // $user = Auth::user();
        $user = $request->user();
        $id = $user->id;
        $theme = $user->theme;

        $budget_period = date('F') . " " . date('Y');

        $budget = Budget::where('user_id', $id)->get();

        if (count($request->query()) > 0)
        {
            $budget_period = $request->query('month') . " " . $request->query('year');
            $current = $budget->where('period', $budget_period);
        }
        else
        {
            $current = $budget->where('period', $budget_period);
        }

        $icons = DB::table('icons')->orderBy('text', 'asc')->get();
        foreach ($icons as $icon)
        {
            $studly_icon = Str::studly($icon->text);
            $icon->display = preg_replace('/(?<=[a-z])(?=\p{Lu})/u', ' ', $studly_icon);
        }
        // $iconsdisplay = array_map('Str::studly', $iconsDisplay);
        // Log::info($iconsdisplay);
        /*
        $response = new BudgetSheet($id);
        */
        // If Budget sheet doesn't exist, create a new one.
        if (sizeof($current) == 0)
        {
            new StoreBudget($user);
            return redirect('budget');
            // $response = new BudgetSheet($id);
        }


        $all_budgets = $budget->unique(function ($item) {
            return $item['month'] . $item['year'];
        });

        $period_array = explode(" ", $budget_period);

        $months = $all_budgets->pluck('month')->unique()->filter(function ($value) use ($period_array) {
            return $value != $period_array[0];
        });

        $years = $all_budgets->pluck('year')->unique()->filter(function ($value) use ($period_array) {
            return $value != $period_array[1];
        });

        return view('content.budget.index')->with([
            'budget' => $current,
            'period' => $budget_period,
            'icons' => $icons,
            'theme' => $theme,
            'months' => $months,
            'years' => $years,
            'period_month' => $period_array[0],
            'period_year' => $period_array[1]
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
        $month = date('F');
        $year = date('Y');
        if (count($request->all()) > 3)
        {
            $user = $request->user();
            $inputCount = count($request->all()) - 2;
            $inputs = $request->all();
            $line = 1;
            $category = $inputs['category'];
            $planned = $inputs['planned'];
            new StoreCategory($category, $planned, $user, $month, $year);
            while ($line <= $inputCount / 2)
            {
                $category = $inputs['category' . $line];
                $planned = $inputs['planned' . $line];
                new StoreCategory($category, $planned, $user, $month, $year);
                $line++;
            }
            return redirect(route('budget'));
        } else
        {
            Log::debug("Attempting to add new category.");
            $request->validate([
                'category' => 'required|string',
                'planned' => 'required|numeric'
            ]);

            $user = $request->user();

            $new_category = $request->input('category');
            $new_planned_budget = $request->input('planned');

            $action = new StoreCategory($new_category, $new_planned_budget, $user, $month, $year);

            return redirect(route('budget'));

        }
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

        foreach ($new_budget as $index => $category)
        {
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
