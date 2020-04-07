<?php


namespace App\Actions\Budget;

use App\Budget;
use Exception;

class Labels 
{
	public function __construct($budget, $form=false) 
	{
		$this->categories = [];
        foreach($budget as $index => &$category) {
        	if ($form || $category["actual"] > 0) {
        		$this->categories[] = $category["category"];
        	}
        }
	}

}