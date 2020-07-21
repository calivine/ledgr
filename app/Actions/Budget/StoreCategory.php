<?php


namespace App\Actions\Budget;

use App\Budget;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class StoreCategory
{
    public function __construct($new_category, $new_planned_budget, $user)
    {

        $category = new Budget;
        $category->category = $new_category;
        $category->planned = $new_planned_budget;
        $category->year = date('Y');
        $category->month = date('F');
        $category->period = date('F') . ' ' . date('Y');
        $category->user()->associate($user);

        $category->save();

        Log::info('Saved new category ' . $new_category);

        $this->rda = [
            'category' => $new_category,
            'planned' => $new_planned_budget
        ];
    }

}
