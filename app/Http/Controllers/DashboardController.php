<?php

namespace App\Http\Controllers;

use App\Actions\Budget\GetBudget;
use App\Actions\Budget\GetActuals;
use App\Actions\Budget\Labels;
use App\Activity;
use App\Budget;
use App\Actions\Utility\DateUtility;
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

        Log::info(time() . ': User: ' . $id . ' entered the Dashboard');

        // Set Timezone.
        date_default_timezone_set('America/New_York');

        // Get Current Month's Budget. 
        $budget = new GetBudget(Auth::user());

        // Gets Total Monthly Spending data for progress bar. 
        $monthly_total_bar = new MonthlyTotal($budget->budget);

        // Gets Budget Category Totals data for progress bars.
        $budget_totals = new BudgetTotals($budget->budget);

        // Fetch labels for New Transaction Form.
        $category_form_labels = new Labels($budget->budget, true);

        // Get Category Labels data for Pie Chart
        $categories = new Labels($budget->budget);

        // Get First And Last Days Of Current Month
        $month_start = DateUtility::first_of_month();
        $month_end = DateUtility::last_of_month();
        $todays_date = DateUtility::todays_date();
        $days_remaining = DateUtility::days_remaining();

        // Pull Transactions For The Current Period
        $transactions = Activity::with('budget')->whereBetween(
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
        $actuals = new GetActuals($budget->budget);

        return view('dashboard')->with([
            'categories' => $categories->categories,
            'category_form_labels' => $category_form_labels->categories,
            'transactions' => $transactions,
            'actuals' => $actuals->rda,
            'today' => $todays_date,
            'days_remaining' => $days_remaining,
            'monthly_total_bar' => $monthly_total_bar->rda,
            'budget_totals_bars' => $budget_totals->rda
        ]);
    }
}
