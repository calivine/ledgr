<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class FileController extends Controller
{

    /**
     * POST
     * /upload/csv
     * Handle CSV uploads of transaction data.
     */
    public function uploadCSV(Request $request)
    {

        if ( ($request->hasFile('csvFile')) && ($request->file('csvFile')->getClientOriginalExtension() == 'csv') )
        {
            $uploaded_file = [];
            $file = $request->file('csvFile');
            $file_contents = file($file);
            foreach($file_contents as $row) {
                $uploaded_file[] = explode(',' ,$row);
            }
            return view('content.activity.upload')->with([
                    'transactions' => $uploaded_file
            ]);
        }
        return abort(500);

    }
}
