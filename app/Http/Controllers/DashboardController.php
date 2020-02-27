<?php

namespace App\Http\Controllers;

use App\Activity;
use App\Actions\Utility\DateUtility;
use App\Actions\Utility\BudgetUtility;
use Illuminate\Support\Facades\Auth;

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
            ->orderBy('date', 'desc')
            ->get();

        foreach($transactions as $transaction) {
            $transaction->date = DateUtility::date_to_string($transaction->date);
        }

        $actuals = $budgetUtil->get_actuals();
        $monthly_budget = $budgetUtil->total_budget();
        $categories = $budgetUtil->labels();
        $monthly_exp = $budgetUtil->total_spending();

        $budget = $budgetUtil->get();

        $category_form_labels = $budgetUtil->get_form_labels();
        sort($category_form_labels);

        if ($monthly_budget > 0) {
            $budget_percent = round(($monthly_exp / $monthly_budget) * 100);
        }
        else {
            $budget_percent = 0;
        }

        return view('dashboard')->with([
            'categories' => $categories,
            'category_form_labels' => $category_form_labels,
            'transactions' => $transactions,
            'actuals' => $actuals,
            'monthly_expenditure' => $monthly_exp,
            'monthly_budget' => $monthly_budget,
            'budget_percent' => $budget_percent,
            'budget' => $budget
        ]);
    }
}
