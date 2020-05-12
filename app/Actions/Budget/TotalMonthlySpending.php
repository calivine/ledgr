<?php


namespace App\Actions\Budget;

use App\Budget;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

/**
* Tallies total monthly spending
*
* @category     Action
*
* @author       Alex Caloggero
* @param        Budget  budget
* @return       Number  planned budget
* @return       Number  actual budget
* @return       Integer percent value
* @return       String  bar color
*/

class TotalMonthlySpending
{
    private $year;
    private $month;
    private $total_monthly_budget = 0.0;
    private $total_monthly_spending = 0.0;

    public function __construct($budget)
    {
        $this->year = date('Y');
        $this->month = date('F');
        // Calculate Totals
        foreach($budget as $index => &$category) {
            $this->total_monthly_spending += $category->actual;
            $this->total_monthly_budget += $category->planned;
        }
        
        $percent_value = $this->total_monthly_budget > 0
                         ? round(($this->total_monthly_spending / $this->total_monthly_budget) * 100)
                         : 0;

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

}
