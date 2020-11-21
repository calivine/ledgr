<?php

namespace App\Actions\Activity;

use App\Activity;

class DestroyActivity
{
	public function __construct($id)
	{
			$activity = Activity::find($id);

			if($activity == null) {
				return;
			} 

			$budget = $activity->budget;

			$budget->actual -= $activity->amount;
			$budget->save();

			$activity->delete();
	}
}
