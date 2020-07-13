<?php

namespace App\Charts;

use App\Activity;
use App\Budget;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


/**
 * Contains data and functionality for
 * charts and graphs.
 *
 * @category   Charts
 *
 * @author     Alex Caloggero
 */
class Chart
{
    /**
     * The type of chart
     *
     * @var    string
     */
    protected $type;

    /**
     * Data structure for the chart
     *
     * @var   array
     */
    protected $data;

    /**
     *
     *
     */
     public $chart;

    public function __construct($type = null, $data = null)
    {
        $this->type = $type;

        $this->data = $data;

        switch ($this->type)
        {
            case 'pie':
                $this->chart = $this->pie();
                break;
            case 'line':
                $this->chart = $this->line();
                break;
        }

    }

    protected function pie()
    {
        $data = [];
        $actuals = [];
        $categories = get_labels($this->data, True);
        foreach($this->data as $index => &$category) {
            if ($category->actual > 0)
            {
                $actuals[] = $category->actual;
            }
        }
        $data["labels"] = $categories;
        $data["actuals"] = $actuals;
        return $data;
    }


    protected function line()
    {

        $budget_history = [];
        $grouped_budgets = $this->data->groupBy('month');
        $index = 0;

        $grouped_budgets_array = $grouped_budgets->toArray();

        foreach($grouped_budgets as $budget) {
            $budget_history[array_keys($grouped_budgets_array)[$index]] = $budget->sum('actual');
            $index++;

        }
        $budget_history_int = [];
        foreach($budget_history as $key => $budget) {

            $budget_history_int[date_parse($key)['month']] = $budget;
        }

        ksort($budget_history_int);

        $sorted_budget = [];
        foreach($budget_history_int as $key => $budget) {
            $sorted_budget[date('F', mktime(0,0,0, $key))] = $budget;
        }
        $data = [];
        $data['labels'] = array_keys($sorted_budget);
        $data['actuals'] = array_values($sorted_budget);
        return $data;
    }



}
