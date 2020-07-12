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
        $grouped_budgets = $this->data->groupBy('period');
        $index = 0;
        
        foreach($grouped_budgets as $budget) {
            $budget_history[$grouped_budgets->keys()[$index]] = $budget->sum('actual');
            $index++;
        }
        $data = [];
        $data['labels'] = array_keys($budget_history);
        $data['actuals'] = array_values($budget_history);
        return $data;
    }



}
