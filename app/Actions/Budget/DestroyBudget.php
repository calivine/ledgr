<?php

namespace App\Actions\Budget;

use App\Budget;

class DestroyBudget
{
	public function __construct($id)
	{
			$budget = Budget::find($id);


			$budget->delete();
	}
}
