<?php

namespace App\Http\Controllers;

use App\Bill;

use Illuminate\Http\Request;

class BillsController extends Controller
{
    public function storeBill(Request $request)
    {
        $user = $request->user();
        /*
        // Validate User Input
        $request->validate([
            'description' => 'required|string',
            'amount' => 'required|min:0|numeric',
            'frequency' => 'required',
            'due' => 'required|regex:/[0-3]{1}[0-9]{1}/'
        ]);

        // Get input values from form
        $description = $request->input('description');
        $amount = $request->input('amount');
        $freq = $request->input('frequency');
        $due = $request->input('due');
        */

        $description = 'Test bill';
        $amount = 14.95;
        $freq = 'monthly';
        $due = 15;

        $bill = new Bill();

        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $alphID = '';
        for ($i = 1; $i <= 64; $i++) {

            $alphID .= $characters[rand(0, strlen($characters)-1)];
        }

        $bill->id = $alphID;
        $bill->description = $description;
        $bill->amount = $amount;
        $bill->frequency = $freq;
        $bill->due = $due;
        $bill->user()->associate($user);
        $bill->save();


        return redirect()->route('dashboard');

    }
}
