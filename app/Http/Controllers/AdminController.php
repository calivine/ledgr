<?php

namespace App\Http\Controllers;

use App\Activity;
use App\Budget;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;



class AdminController extends Controller
{
    function backupTables()
    {
        $encrypted_table = [];
        $activities = Activity::all();
        foreach($activities as $activity) {
            // Log::info($activity);
            $encrypted = encrypt($activity);
            // Log::info($encrypted);
            // Log::info(decrypt($encrypted));
            $encrypted_table[] = $encrypted;
        }

        $fp = fopen(database_path('backup.json'), 'w') or die('Failure!');
        fwrite($fp, json_encode($encrypted_table));
        fclose($fp);

    }

    function readBackupTables()
    {
        $json = file_get_contents(database_path('backup.json'));
        $json_data = json_decode($json, true);
        foreach($json_data as $transaction) {
            Log::info($transaction);
            Log::info(decrypt($transaction));
        }
    }

    function formatPeriodColumn()
    {
        $budgets = Budget::all();
        foreach($budgets as $budget) {

            if ($budget->period == '')
            {
                Log::info($budget->period);
                $budget->period = $budget->month . ' ' . $budget->year;
                Log::info($budget->period);
                $budget->save();
            }

        }
    }



}
