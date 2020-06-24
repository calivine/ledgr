<?php


namespace App\Actions\Budget;

use App\Budget;
use Exception;

/**
* Delivers monthly budget data for a user
*
* @category Action
*
* @author Alex Caloggero
*
*/

class GetBudget
{

    public $budget = [];

    /**
    * Deliver monthly budget data
    *
    * @param User    user
    * @param integer year
    * @param string  month
    */
    public function __construct($user, $year = null, $month = null)
    {
        try {
            $date = $year ?? date('Y');
            $month = $month ?? date('F');
            $budget = Budget::where([
                ['year', '=', $date],
                ['month', '=', $month],
                ['user_id', '=', $user->id]
            ])
            ->orderBy('category')
            ->get();
            $this->budget = $this->get_safe_budget($budget);
        } catch (Exception $e) {
            report($e);
        }
    }

    /**
    * Safely delivers the necessary budget data to a GetBudget request
    *
    * @param App\Budget budget
    */
    protected function get_safe_budget($budget)
    {
        $safe_budget = [];
        if ($budget->isNotEmpty()) {
            foreach ($budget as $row) {
                $new_row = [
                    'id' => $row->id,
                    'icon' => $row->icon,
                    'category' => $row->category,
                    'planned' => $row->planned,
                    'actual' => $row->actual,
                    'year' => $row->year,
                    'month' => $row->monthly
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
