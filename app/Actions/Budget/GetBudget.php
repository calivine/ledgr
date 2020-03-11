<?php


namespace App\Actions\Budget;

use App\Budget;
use Exception;

class GetBudget
{

    public $budget = [];

    public function __construct($user, $year = null, $period = null)
    {
        try {
            $date = $year ?? date('Y');
            $period = $period ?? date('F');
            $budget = Budget::where([
                ['year', '=', $date],
                ['period', '=', $period],
                ['user_id', '=', $user->id]
            ])
            ->orderBy('category')
            ->get();
            $this->budget = $this->get_safe_budget($budget);
        } catch (Exception $e) {
            report($e);
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
