<?php


namespace App\Repository;

use App\Activity;
use App\Budget;
use App\Actions\Activity\StoreActivity;
use DB;
use Log;
use Request;


class Activities
{
    CONST CACHE_KEY = 'ACTIVITIES';

    public function getActivitiesByDate($from, $to, $user)
    {

        if (!preg_match('/^[\d]{4}-[\d]{1,2}-[\d]{1,2}$/', $from))
        {
            Log::info('Error');
            //return json('status' => 500);
        }
        else
        {
            Log::info('Okay');
        }
        return DB::table('activities')
            ->where('user_id', '=', $user)
            ->whereBetween('date', [$from, $to])
            ->get();
    }

    public function storeTransaction(Request $request)
    {
        $date = $request->input('date');
        $amount = $request->input('amount');
        $amount = $request->input('description');
        $amount = $request->input('category');

        $user = $request->user()->id;

        $activity = new StoreActivity($date, $amount, $description, $category, $user);

        return $activity;

    }
}
