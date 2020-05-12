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

        // Fail to register a new user.
        $response = $this->withHeaders([
            'X-Header' => 'Value',
        ])->json('POST', '/register', [
            'name' => 'alexcalog112',
            'email' => 'testmail@email.com',
            'password' => 'test',
            'password_confirmation' => 'test'
        ]);
        // Assert request is Unprocessable because pw is too short.
        $response->assertStatus(422);

        $response = $this->actingAs($user)
        ->withSession(['user' => 'acali'])
        ->withHeaders([
            'X-Header' => 'Value',
        ])->json('POST', '/transaction', [
            'description' => 'ATM',
            'amount' => '10.00',
            'category' => 'Cash',
            'transaction_date' => '2020-02-01'
        ]);
        $response->assertStatus(200);

        $response = $this->actingAs($user)
        ->withSession(['user' => 'acali'])
        ->withHeaders([
            'X-Header' => 'Value',
        ])->json('POST', '/transaction', [
            'description' => 'Car Payment',
            'amount' => '15.33',
            'category' => 'Debt',
            'transaction_date' => '2020-03-16'
        ]);
        $response->assertStatus(200);

        $response = $this->actingAs($user)
        ->withSession(['user' => 'acali'])
        ->withHeaders([
            'X-Header' => 'Value',
        ])->json('POST', '/transaction', [
            'description' => '7-11',
            'amount' => '14.88',
            'category' => 'Food',
            'transaction_date' => '2020-05-10'
        ]);
        $response->assertStatus(200);

        $response = $this->withSession(['user' => 'acali'])
        ->withHeaders([
            'X-Header' => 'Value',
        ])->json('GET', '/dashboard');
        $response->assertStatus(200);

    }
}
