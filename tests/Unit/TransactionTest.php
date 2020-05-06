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
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)
        ->withSession(['user' => 'acali'])
        ->withHeaders([
            'X-Header' => 'Value',
        ])->json('POST', '/transaction', [
            'description' => 'test',
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
            'description' => 'Test',
            'amount' => '15.00',
            'category' => 'Food',
            'transaction_date' => '2020-03-01'
        ]);
        $response->assertStatus(200);

        $response = $this->actingAs($user)
        ->withSession(['user' => 'acali'])
        ->withHeaders([
            'X-Header' => 'Value',
        ])->json('POST', '/transaction', [
            'description' => '7\/11',
            'amount' => '21.00',
            'category' => 'Food',
            'transaction_date' => '2020-03-12'
        ]);
        $response->assertStatus(200);

    }
}
