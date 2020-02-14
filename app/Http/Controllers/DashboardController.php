<?php

namespace App\Http\Controllers;
use App\Budget;
use App\Activity;

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
        // Set Timezone
        date_default_timezone_set('America/New_York');

        // Get Current Period: Month/Year
        $date = date('Y');
        $period = date('F');

        // Get First And Last Days Of Current Month
        $timestamp = strtotime(date('f Y'));
        $month_start = date('Y-m-01', $timestamp);
        $month_end = date('Y-m-t', $timestamp);

        // Pull Transactions For The Current Period
        $transactions = Activity::whereBetween(
            'date', [$month_start, $month_end])
            ->get();

        // Get Budget Sheet For Current Period
        $budget = Budget::where([
            ['year', '=', $date],
            ['period', '=', $period]
        ])->get();

        // Data To Be Formatted For Display On Dashboard
        $categories = [];
        $actuals = [];
        $monthly_budget = 0.0;

        /*
         * Format Budget Sheet Into:
         *      Category Labels
         *      Actuals List
         *      Total Monthly Budget
         */
        foreach($budget as $category) {
            $categories[] = $category->category;
            $actuals[] = $category->actual;
            $monthly_budget += $category->planned;
        }

        // Sum Up Total Monthly Expenditure
        $monthly_exp = array_sum($actuals);

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
            'budget_percent' => $budget_percent
        ]);
    }

    /*
     * POST
     * /save_transaction
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

        // Save transaction to Activities table
        $activity = new Activity();
        $activity->description = $description;
        $activity->amount = $amount;
        $activity->category = $category;
        $activity->date = $date;
        // Create function that generates random 36 character alpha-num string
        $activity->transaction_id = "TestTransaction";

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
