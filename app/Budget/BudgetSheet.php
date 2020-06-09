<?php

namespace App\Budget;

use App\Budget;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
* Class representing a monthly budget sheet.
*
* @category Budget
*
* @param    date Month
* @param    date Year
*
* @author   Alex Caloggero
*/
class BudgetSheet
{
    private $user;
    public $budget = [];

    public function __construct($user_id, $month=null, $year=null)
    {
        try {
            /*
            $budgetSheet = Budget::where([
                ['year', '=', $year ?? date('Y')],
                ['period', '=', $month ?? date('F')],
                ['user_id', '=', $user_id]
            ])
            ->orderBy('category')
            ->get();
            */
            $budgetSheet = DB::table('budgets')
                                    ->where([
                                        ['year', '=', $year ?? date('Y')],
                                        ['period', '=', $month ?? date('F')],
                                        ['user_id', '=', $user_id]
                                    ])
                                    ->select('id',
                                             'icon',
                                             'category',
                                             'planned',
                                             'actual',
                                             'year',
                                             'period')
                                    ->orderBy('category')
                                    ->get()
                                    ->toArray();

            // $this->budget = $this->get_safe_budget($budgetSheet);
            $this->budget = $budgetSheet;
        } catch (Exception $e) {
            report($e);
            abort(403);
        }
    }

    /**
     * Returns data representing Pie Chart.
     */
    public function get_chart_data()
    {
        $data = [];
        $actuals = [];
        $categories = get_labels($this->budget, True);
        foreach($this->budget as $index => &$category) {
            if ($category->actual > 0)
            {
                $actuals[] = $category->actual;
            }
        }
        $data["labels"] = $categories;
        $data["actuals"] = $actuals;
        return $data;
    }

    /**
     * Returns data representing Budget Actuals.
     */
    public function actuals()
    {
        return $this->build_return_data("actual");
    }

    /**
     * Returns data representing Budget Planned Values.
     */
    public function planned()
    {
        return $this->build_return_data("planned");
    }

    protected function build_return_data($type)
    {
        $data = [];
        foreach($this->budget as $index => &$category) {
            $data[] = $category->$type;
        }
        return $data;
    }
}
