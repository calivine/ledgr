<?php

namespace App\Http\Controllers;

use App\Budget;
use App\Activity;
use App\Actions\Utility\DateUtility;
use App\Actions\Utility\BudgetUtility;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /*
     * GET
     * /dashboard
     * User Homepage
     */
    public function index()
    {
        // Retrieve User
        $id = Auth::id();

        // Set Timezone
        date_default_timezone_set('America/New_York');

        // Initialize Budget Utility
        $budgetUtil = new BudgetUtility($id);

        // Get First And Last Days Of Current Month

        $month_start = DateUtility::first_of_month();
        $month_end = DateUtility::last_of_month();

        // Pull Transactions For The Current Period
        $transactions = Activity::whereBetween(
            'date', [$month_start, $month_end])
            ->where('user_id', $id)
            ->get();


        $actuals = $budgetUtil->get_actuals();
        $monthly_budget = $budgetUtil->total_budget();
        $categories = $budgetUtil->labels();
        $monthly_exp = $budgetUtil->total_spending();

        $budget = $budgetUtil->get();


        if ($monthly_budget > 0) {
            $budget_percent = round(($monthly_exp / $monthly_budget) * 100);
        }
        else {
            $budget_percent = 0;
        }

        return view('dashboard')->with([
            'categories' => $categories,
            'transactions' => $transactions,
            'actuals' => $actuals,
            'monthly_expenditure' => $monthly_exp,
            'monthly_budget' => $monthly_budget,
            'budget_percent' => $budget_percent,
            'budget' => $budget
        ]);
    }

    /*
     * POST
     * /transaction/new
     * Saves a transaction
     */
    public function saveTransaction(Request $request)
    {
        $request->validate([
            'description' => 'required',
            'amount' => 'required',
            'category' => 'required',
            'transaction_date' => 'required'
        ]);

        // Get input values from form
        $description = $request->input('description');
        $amount = $request->input('amount');
        $category = $request->input('category');
        $date = $request->input('transaction_date');

        // Get User Object
        $user = $request->user();

        // Save Transaction To Activities Table
        $activity = new Activity();

        $activity->description = $description;
        $activity->amount = $amount;
        $activity->category = $category;
        $activity->date = $date;
        // Create function that generates random 36 character alpha-num string
        $activity->transaction_id = "TestTransaction";
        // Link To User Signed-In
        $activity->user()->associate($user);

        // Update Actual Budget Value
        $budget = Budget::where([
            ['category', $category],
            ['period', date('F')],
            ['year', date('Y')]
        ])->first();

        $budget->actual = $budget->actual + $amount;

        $budget->save();
        $activity->save();

    }
}
