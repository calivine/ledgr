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

    public function __construct($budget)
    {
        $this->year = date('Y');
        $this->month = date('F');
        if (Auth::check())
        {
            // Calculate Totals
            foreach($budget as $index => &$category) {

                $this->total_monthly_spending += $category->actual;
                $this->total_monthly_budget += $category->planned;
            }
            $percent_value = $this->total_monthly_budget > 0 ? round(($this->total_monthly_spending / $this->total_monthly_budget) * 100) : 0;

            if ($percent_value < 75)
            {
                $bar_color = 'success';
            }
            else if ($percent_value >= 100 && $percent_value <= 101)
            {
                $bar_color = 'primary';
            }
            else if ($percent_value >= 75 && $percent_value < 100)
            {
                $bar_color = 'warning';
            }
            else
            {
                $bar_color = 'danger';
            }
            $this->rda = [
                'planned' => $this->total_monthly_budget,
                'actual' => $this->total_monthly_spending,
                'percent' => $percent_value,
                'color' => $bar_color
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
                    'period' => $row['period']
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

}
