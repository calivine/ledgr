<?php


namespace App\Actions\Budget;

use App\Budget;
use Illuminate\Http\Request;


class StoreCategory
{
    public function __construct(Request $request)
    {
        $user = $request->user();
        $new_category = $request->input('name');
        $new_planned_budget = $request->input('planned');
        $category = new Budget;
        $category->category = $new_category;
        $category->planned = $new_planned_budget;
        $category->year = date('Y');
        $category->period = date('F');
        $category->user()->associate($user);

        $category->save();

        $this->rda = [
            'category' => $new_category,
            'planned' => $new_planned_budget
        ];
    }

}