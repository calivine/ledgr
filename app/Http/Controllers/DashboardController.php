<?php

namespace App\Http\Controllers;

use App\Activity;
use App\Budget;
use App\Actions\Budget\GetActuals;
use App\Actions\ProgressBar\MonthlyTotal;
use App\Actions\ProgressBar\BudgetTotals;
use App\Budget\BudgetSheet;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

/**
 * Builds and displays the main dashboard.
 *
 * @category   Controllers
 *
 * @author     Alex Caloggero
 */
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
        $budget = new BudgetSheet($id);

        // Get data for pie chart.
        $chart_data = $budget->get_chart_data();

        // Gets Total Monthly Spending data for progress bar.
        $monthly_total_bar = new MonthlyTotal($budget->budget);

        // Gets Budget Category Totals data for progress bars.
        $budget_totals = new BudgetTotals($budget->budget);

        // Fetch labels for New Transaction Form.
        $category_form_labels = get_labels($budget->budget);

        // Get First And Last Days Of Current Month
        $month_start = first_of_month();
        $month_end = last_of_month();
        $todays_date = todays_date();
        $days_remaining = days_remaining();

        // Pull Transactions For The Current Period
        $transactions = Activity::with('budget')->whereBetween(
            'date', [$month_start, $month_end])
            ->where('user_id', $id)
            ->orderBy('date', 'desc')
            ->get();

        // Format Date and Amount For Display On Dashboard
        foreach($transactions as $transaction) {
            $transaction->date = date_to_string($transaction->date);
            $transaction->amount = number_format($transaction->amount, 2);
        }

        return view('dash.dashboard')->with([
            'categories' => $chart_data["labels"],
            'category_form_labels' => get_labels($budget->budget),
            'transactions' => $transactions,
            'actuals' => $chart_data["actuals"],
            'today' => $todays_date,
            'days_remaining' => $days_remaining,
            'monthly_total_bar' => $monthly_total_bar->rda,
            'budget_totals_bars' => $budget_totals->rda
        ]);
    }
}
