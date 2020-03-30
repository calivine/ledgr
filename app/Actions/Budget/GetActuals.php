<?php


namespace App\Actions\Budget;

use App\Budget;
use Exception;

class GetActuals
{
    public function __construct($budget)
    {
        $actuals = [];
        foreach($budget as $index => &$category) {
            if ($category['actual'] > 0) {
                $actuals[] = $category['actual'];
            }
        }
        return $actuals;

    }

}
