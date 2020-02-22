<?php


namespace App\Actions\Budget;

use App\Budget;
use Exception;

class GetBudget
{
    public $budget;

    public function __construct($user, $year = null, $period = null)
    {
        try {
            $date = $year ?? date('Y');
            $period = $period ?? date('F');
            $this->budget = Budget::where([
                ['year', '=', $date],
                ['period', '=', $period],
                ['user_id', '=', $user->id]
            ])->get();
            if ($this->budget->isEmpty()) {
                new StoreBudget($user);
                $this->budget = new GetBudget($user);
            }
        } catch (Exception $e) {
            report($e);

        }
    }

}