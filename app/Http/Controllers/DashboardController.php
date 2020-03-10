<?php

namespace App\Http\Controllers;

use App\Activity;
use App\Actions\Utility\DateUtility;
use App\Actions\Utility\BudgetUtility;
use App\Actions\ProgressBar\MonthlyTotal;
use App\Actions\ProgressBar\BudgetTotals;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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

        Log::info(time() . ': ' . $id);

        // Set Timezone
        date_default_timezone_set('America/New_York');

        // Initialize Budget Utility
        $budgetUtil = new BudgetUtility($id);

        $monthly_total_bar = new MonthlyTotal();

        $budget_totals = new BudgetTotals();

        // Get First And Last Days Of Current Month
        $month_start = DateUtility::first_of_month();
        $month_end = DateUtility::last_of_month();
        $todays_date = DateUtility::todays_date();
        $days_remaining = DateUtility::days_remaining();

        // Pull Transactions For The Current Period
        $transactions = Activity::whereBetween(
            'date', [$month_start, $month_end])
            ->where('user_id', $id)
            ->orderBy('date', 'desc')
            ->get();

        // Format Date and Amount For Display On Dashboard
        foreach($transactions as $transaction) {
            $transaction->date = DateUtility::date_to_string($transaction->date);
            $transaction->amount = number_format($transaction->amount, 2);
        }

        // Get Actuals For Each Budget Category
        $actuals = $budgetUtil->get_actuals();

        $categories = $budgetUtil->labels();

        $category_form_labels = $budgetUtil->get_form_labels();

        sort($category_form_labels);

        return view('dashboard')->with([
            'categories' => $categories,
            'category_form_labels' => $category_form_labels,
            'transactions' => $transactions,
            'actuals' => $actuals,
            'today' => $todays_date,
            'days_remaining' => $days_remaining,
            'monthly_total_bar' => $monthly_total_bar->rda,
            'budget_totals_bars' => $budget_totals->rda
        ]);
    }
}
