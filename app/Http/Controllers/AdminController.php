<?php

namespace App\Http\Controllers;

use App\Activity;
use App\Budget;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;



class AdminController extends Controller
{
    /**
     * GET
     * /admin/archive
     * Archive encrypted tables
     */
    function backupTables()
    {
        $this->archive(Budget::all(), 'backup_b.json');

        $this->archive(Activity::all(), 'backup.json');

        $this->archive(User::all(), 'backup_u.json');
    }

    /**
     * GET
     * /admin/readArchive
     * Read archived tables
     */
    function readBackupTables()
    {
        $this->retrieve('backup.json');

        $this->retrieve('backup_u.json');
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

    protected function archive($table, $file)
    {
        foreach($table as $row) {
            $encrypted = encrypt($row);
            Log::info($encrypted);
            $encrypted_table[] = $encrypted;
        }

        $fp = fopen(storage_path('app/' . $file), 'w') or die('Failure!');
        fwrite($fp, json_encode($encrypted_table));
        fclose($fp);
    }

    protected function retrieve($file)
    {
        $json = file_get_contents(storage_path('app/' . $file));
        $json_data = json_decode($json, true);
        foreach($json_data as $row) {
            Log::info($row);
            Log::info(decrypt($row));
        }

    }



}
