<?php

namespace App\Budget;

use App\Budget;
use Exception;
use Illuminate\Support\Facades\Auth;

/**
* Delivers data representing a monthly budget sheet.
*
* @category Budget
* @
*/

class BudgetSheet
{
    private $user;
    public $budget = [];

    public function __construct($month=null, $year=null)
    {
        // Check if user is logged in
        $this->user = Auth::user();

        try {
            $budgetSheet = Budget::where([
                ['year', '=', $year ?? date('Y')],
                ['period', '=', $month ?? date('F')],
                ['user_id', '=', $this->user->id]
            ])
            ->orderBy('category')
            ->get();
            $this->budget = $this->get_safe_budget($budgetSheet);
        } catch (Exception $e) {
            report($e);
            abort(403);
        }
    }

    public function get_chart_data()
    {
        $data = [];
        $actuals = [];
        $categories = get_labels($this->budget, $chart=true);
        foreach($this->budget as $index => &$category) {
            if ($category["actual"] > 0)
            {
                $actuals[] = $category["actual"];
            }
        }
        $data["labels"] = $categories;
        $data["actuals"] = $actuals;
        return $data;
    }

    /**
    * Safely delivers the necessary budget data to a GetBudget request
    *
    * @param App\Budget budget
    */
    protected function get_safe_budget($budget)
    {
        $safe_budget = [];
        if ($budget->isNotEmpty())
        {
            foreach ($budget as $row) {
                $new_row = [
                    'id' => $row->id,
                    'icon' => $row->icon,
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
        else
        {
            return $safe_budget;
        }
    }

}
