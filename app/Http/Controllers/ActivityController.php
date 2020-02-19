<?php

namespace App\Http\Controllers;
use App\Activity;

use Illuminate\Http\Request;

class ActivityController extends Controller
{
    /*
     * POST
     * /transaction/category/update
     * Update Transaction's Category
     */
    public function updateCategory(Request $request)
    {
        $update_name = $request->input('update_name');
        $id = $request->input('id');

        $activity = Activity::find($id);
        $activity->category = $update_name;
        $activity->save();

        return response()->json([
            'id' => $id,
            'category' => $update_name
        ]);
    }
}
