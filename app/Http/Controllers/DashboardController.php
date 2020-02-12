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
        // Get Current Period
        $date = date('Y');
        $period = date('F');
        $timestamp = strtotime(date('f Y'));

        $month_start = date('Y-m-01', $timestamp);
        $month_end = date('Y-m-t', $timestamp);

        $transactions = Activity::whereBetween('date', [$month_start, $month_end])->get();

        // Get Budget Sheet For Current Period
        $budget = Budget::where([
            ['year', '=', $date],
            ['period', '=', $period]
        ])->get();

        $categories = [];
        $actuals = [];
        $monthly_exp = 0.0;
        $monthly_budget = 0.0;

        // Category Labels For Manual Input Form
        // Sum Total Monthly Expenditure
        // Create Actuals Table
        foreach($budget as $category) {
            $categories[] = $category->category;
            $actuals[] = $category->actual;
            $monthly_exp += $category->actual;
            $monthly_budget += $category->planned;
        }

        return view('dashboard')->with([
            'categories' => $categories,
            'transactions' => $transactions,
            'actuals' => $actuals,
            'monthly_expenditure' => $monthly_exp,
            'monthly_budget' => $monthly_budget
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
