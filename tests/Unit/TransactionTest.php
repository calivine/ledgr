<?php

namespace Tests\Unit;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TransactionTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testExample()
    {
        // Create a User
        $user = factory(User::class)->create();


        $response = $this->actingAs($user)
        // ->withSession(['user' => 'acali'])
        ->withHeaders([
            'X-Header' => 'Value',
        ])->json('POST', '/transaction', [
            'description' => 'ATM',
            'amount' => '10.00',
            'category' => 'Cash',
            'transaction_date' => '2020-11-01'
        ]);
        $response->assertStatus(200);

        $response = $this->actingAs($user)
        // ->withSession(['user' => 'acali'])
        ->withHeaders([
            'X-Header' => 'Value',
        ])->json('POST', '/transaction', [
            'description' => 'Car Payment',
            'amount' => '15.33',
            'category' => 'Debt',
            'transaction_date' => '2020-11-16'
        ]);
        $response->assertStatus(200);

        $response = $this->actingAs($user)
        //->withSession(['user' => 'acali'])
        ->withHeaders([
            'X-Header' => 'Value',
        ])->json('POST', '/transaction', [
            'description' => '7-11',
            'amount' => '14.88',
            'category' => 'Food',
            'transaction_date' => '2020-11-10'
        ]);
        $response->assertStatus(200);

        $response = $this->actingAs($user)
        //->withSession(['user' => 'acali'])
        ->withHeaders([
            'X-Header' => 'Value',
        ])->json('POST', '/transaction', [
            'description' => 'ATM Fee',
            'amount' => '3.99',
            'category' => 'Fees',
            'transaction_date' => '2020-11-11'
        ]);
        $response->assertStatus(200);


        $response = $this->actingAs($user)
        //->withSession(['user' => 'acali'])
        ->withHeaders([
            'X-Header' => 'Value',
        ])->json('POST', '/budget/icon/update', [
            'id' => '1',
            'icon' => 'plus'
        ]);
        $response->assertStatus(200);

        $response = $this->actingAs($user)
        ->withHeaders([
            'X-Header' => 'Value',
        ])->json('POST', '/budget/planned/update', [
            'id' => '1',
            'new_value' => '110'
        ]);
        $response->assertStatus(200);

        $response = $this->actingAs($user)
        ->get('/budget');

        $response->assertStatus(200);

        $response = $this->actingAs($user)
        ->get('/dashboard');

        $response->assertStatus(200);

        $response = $this->actingAs($user)
        ->deleteJson('/transaction/2/destroy');

        $response->assertStatus(302);


    }
}
