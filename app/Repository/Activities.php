<?php


namespace App\Repository;

use App\Activity;

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
}
