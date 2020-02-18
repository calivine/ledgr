<?php


namespace App\Actions\Utility;

use App\Budget;


class BudgetUtility
{
    private $date;
    private $period;

    private $budget;
    private $total_monthly_budget = 0.0;
    private $total_monthly_spending = 0.0;

    public function __construct($user_id)
    {
        /*
         * Create Budget Utility Object
         * Holds Budget Sheet Data and
         * Planned And Actuals Totals
         * Planned, Actuals, Labels as Arrays For Charts
         */
        $this->date = date('Y');
        $this->period = date('F');
        $this->budget = Budget::where([
            ['year', '=', $this->date],
            ['period', '=', $this->period],
            ['user_id', '=', $user_id]
        ])->get();

        // Calculate Totals
        foreach($this->budget as $category) {
            $this->total_monthly_spending += $category->actual;
            $this->total_monthly_budget += $category->planned;
        }
    }

    public function labels() {
        $categories = [];
        foreach($this->budget as $category) {
            $categories[] = $category->category;
        }
        return $categories;
    }

    public function get() {
        return $this->budget;
    }

    public function total_budget() {
        return $this->total_monthly_budget;
    }

    public function total_spending() {
        return $this->total_monthly_spending;
    }

    public function get_actuals() {
        $actuals = [];
        foreach($this->budget as $category) {
            $actuals[] = $category->actual;
        }
        return $actuals;
    }

}