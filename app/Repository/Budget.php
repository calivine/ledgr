<?php


namespace App\Repository;

use App\Activity;
use App\Actions\Activity\StoreActivity;
use DB;
use Log;
use Illuminate\Http\Request;

class Budget
{
    CONST CACHE_KEY = 'BUDGET';

    /**
    * Returns a single budget category item.
    *
    */
    public function category($user, $category, $filter = null)
    {
        if (is_null($filter))
        {
            return DB::table('budgets')
                ->where([
                    ['year', '=', $year ?? date('Y')],
                    ['month', '=', $month ?? date('F')],
                    ['user_id', '=', $user],
                    ['category', '=', $category]
                ])
                ->select('category',
                         'planned',
                         'actual')
                ->orderBy('category')
                ->get();
        }
        else
        {
            return DB::table('budgets')
                ->where([
                    ['year', '=', $year ?? date('Y')],
                    ['month', '=', $month ?? date('F')],
                    ['user_id', '=', $user],
                    ['category', '=', $category]
                ])
                ->select('category',
                         $filter)
                ->orderBy('category')
                ->get();
        }
    }


}
