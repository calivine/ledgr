<?php


namespace App\Actions\Budget;

use App\Budget;
use Exception;

class GetActuals
{
    public function __construct($budget)
    {
        $this->rda = [];
        foreach($budget as $index => &$category) {
            if ($category["actual"] > 0)
            {
                $this->rda[] = $category["actual"];
            }
        }

    }

}
