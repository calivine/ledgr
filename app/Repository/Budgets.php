<?php


namespace App\Repository;

use App\Activity;
use App\Budget;
use App\Actions\Activity\StoreActivity;
use DB;
use Log;
use Illuminate\Http\Request;

class Budgets
{
    CONST CACHE_KEY = 'BUDGETS';

    public function categories($user)
    {
        return DB::table('budgets')
                            ->where([
                                    ['year', '=', $year ?? date('Y')],
                                    ['month', '=', $month ?? date('F')],
                                    ['user_id', '=', $user]
                                ])
                                ->select('id',
                                         'category')
                                ->orderBy('category')
                                ->get();
    }
}
