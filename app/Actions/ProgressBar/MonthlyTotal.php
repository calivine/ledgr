<?php

namespace App\Actions\ProgressBar;

use App\Budget;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

/**
* Class representing total monthly spending progress bar
*
* @category Actions
*
* @param    array Budget
*
* @author   Alex Caloggero
*/
class MonthlyTotal
{
    private $year;
    private $month;
    private $total_monthly_budget = 0.0;
    private $total_monthly_spending = 0.0;
    private $totals_by_category = [];

    public function __construct($budget)
    {
        /** Progress Bar
         * Represents attributes of Progress Bars
         * on the Dashboard.
         *
         * Parameters:
         * --------------
         * budget:Budget,
         * List of Budget data
         */
        $this->year = date('Y');
        $this->month = date('F');
        if (Auth::check())
        {
            foreach($budget as $index => &$category) {
                $percent = $category->planned > 0 ? round(($category->actual / $category->planned) * 100) : 0;

                $data = [
                    'percent' => $percent,
                    'planned' => $category->planned,
                    'actual' => $category->actual,
                    'color' => $this->get_bar_color($percent),
                    'category' => $category->category
                ];
                $this->totals_by_category[] = $data;
            }

            // Calculate Totals
            foreach($budget as $index => &$category) {

                $this->total_monthly_spending += $category->actual;
                $this->total_monthly_budget += $category->planned;
            }
            $percent_value = $this->total_monthly_budget > 0 ? round(($this->total_monthly_spending / $this->total_monthly_budget) * 100) : 0;

            $bar_color = $this->get_bar_color($percent_value);

            $totals = [
                'planned' => $this->total_monthly_budget,
                'actual' => $this->total_monthly_spending,
                'percent' => $percent_value,
                'color' => $bar_color
            ];
            $this->rda = [
                'monthly_total' => $totals,
                'budget_totals' => $this->totals_by_category
            ];

        }
        else
        {
            // If User is Not Authenticated, Quit and Return Null Budget
            Log::info('Could Not Authenticate. Please sign in.');
        }
    }

    protected function get_safe_budget($budget)
    {
        $safe_budget = [];
        if ($budget->isNotEmpty())
        {
            foreach ($budget as $index => &$row) {
                $new_row = [
                    'id' => $row['id'],
                    'category' => $row['category'],
                    'planned' => $row['planned'],
                    'actual' => $row['actual'],
                    'year' => $row['year'],
                    'month' => $row['month']
                ];
                $safe_budget[] = $new_row;
            }
            return $safe_budget;
        }
        else
        {
            return $safe_budget;
        }
    }

    protected function get_bar_color($percent_value)
    {
        if ($percent_value < 75)
        {
            return 'success';
        }
        else if ($percent_value >= 100 && $percent_value <= 101)
        {
            return 'primary';
        }
        else if ($percent_value >= 75 && $percent_value < 100)
        {
            return 'warning';
        }
        else
        {
            return 'danger';
        }
    }

}
