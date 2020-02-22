<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        $response = $this->withHeaders([
            'X-Header' => 'Value',
        ])->json('POST', '/register', [
            'name' => 'alexcalog112',
            'email' => 'testmail@email.com',
            'password' => 'testemail',
            'password_confirmation' => 'testemail'
        ]);

        $response->assertStatus(422);
    }
}
