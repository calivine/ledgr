<?php

namespace App\Http\Controllers;

use App\Activity;
use App\Budget;
use App\Actions\Budget\GetActuals;
use App\Actions\ProgressBar\MonthlyTotal;
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
        // Set Timezone.
        date_default_timezone_set('America/New_York');

        // Retrieve User
        $id = Auth::id();

        Log::info(now() . ': User: ' . $id . ' entered the Dashboard');

        // Get Current Month's Budget.
        $budget = new BudgetSheet($id);

        // Get data for pie chart.
        $chart_data = $budget->get_chart_data();

        // Gets Total Monthly Spending data for progress bar.
        $progress_bars = new MonthlyTotal($budget->budget);

        // Fetch labels for New Transaction Form.
        $category_form_labels = get_labels($budget->budget);
        if (empty($category_form_labels))
        {
            Log::info($category_form_labels);
            $json = file_get_contents(database_path('budget.json'));
            $json_data = json_decode($json, true);
            foreach($json_data['data'] as $budget) {
                $category_form_labels[] = $budget['category'];
            }
        }
        Log::info($category_form_labels);

        // Get First And Last Days Of Current Month
        $dates = [
            'month_start' => first_of_month(),
            'month_end' => last_of_month(),
            'todays_date' => todays_date(),
            'days_remaining' => days_remaining()
        ];


        // Pull Transactions For The Current Period
        $transactions = Activity::with('budget')->whereBetween(
            'date', [$dates['month_start'], $dates['month_end']])
            ->where('user_id', $id)
            ->orderBy('date', 'desc')
            ->get();

        // Format Date and Amount For Display On Dashboard
        foreach($transactions as $transaction) {
            $transaction->date = date_to_string($transaction->date);
            $transaction->amount = number_format($transaction->amount, 2);
        }

        return view('dash.dashboard')->with([
            'actuals' => $chart_data["actuals"],
            'budget_totals_bars' => $progress_bars->rda['budget_totals'],
            'categories' => $chart_data["labels"],
            'category_form_labels' => get_labels($budget->budget),
            'dates' => $dates,
            'monthly_total_bar' => $progress_bars->rda['monthly_total'],
            'transactions' => $transactions
        ]);
    }
}
