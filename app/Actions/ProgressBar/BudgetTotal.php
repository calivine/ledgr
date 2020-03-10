<?php

namespace App\Actions\ProgressBar;

use App\Budget;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;



class BudgetTotal
{
    private $year;
    private $month;
    private $total_monthly_budget = 0.0;
    private $total_monthly_spending = 0.0;

    public function __construct()
    {
        $this->year = date('Y');
        $this->month = date('F');
        if (Auth::check()) {
            $user = Auth::user();

            try {
                $budget = Budget::where([
                    ['year', '=', $this->year],
                    ['period', '=', $this->month],
                    ['user_id', '=', $user->id]
                ])->get();

            } catch (Exception $e) {
                report($e);
                Log::info('Could not find data with the supplied parameters.');
            }

            // Calculate Totals
            foreach($budget as $category) {

                $this->total_monthly_spending += $category->actual;
                $this->total_monthly_budget += $category->planned;
            }

            if ($this->total_monthly_budget > 0) {
                $percent_value = round(($this->total_monthly_spending / $this->total_monthly_budget) * 100);
            }
            else {
                $percent_value = 0;
            }

            if ($percent_value < 75) {
                $bar_color = 'primary';
            }
            else if ($percent_value >= 100 && $percent_value <= 101) {
                $bar_color = 'success';
            }
            else if ($percent_value >= 75 && $percent_value < 100) {
                $bar_color = 'warning';
            }
            else {
                $bar_color = 'danger';
            }
            $this->rda = [
                'planned_total' => $this->total_monthly_budget,
                'actual_total' => $this->total_monthly_spending,
                'percent' => $percent_value,
                'color' => $bar_color
            ];

        }
        else {
            // If User is Not Authenticated, Quit and Return Null Budget
            Log::info('Could Not Authenticate. Please sign in.');
        }
    }

    protected function get_safe_budget($budget)
    {
        $safe_budget = [];
        if ($budget->isNotEmpty()) {
            foreach ($budget as $row) {
                $new_row = [
                    'id' => $row->id,
                    'category' => $row->category,
                    'planned' => $row->planned,
                    'actual' => $row->actual,
                    'year' => $row->year,
                    'period' => $row->period
                ];
                $safe_budget[] = $new_row;
            }
            return $safe_budget;
        }
        else {
            return $safe_budget;
        }
    }

}
