<?php

use Illuminate\Database\Seeder;
use App\User;
use Illuminate\Support\Str;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = file_get_contents('database/users.json');
        $json_data = json_decode($json, true);
        foreach($json_data['data'] as $user) {
            $new_user = User::updateOrCreate(
                ['email' => $user['email'], 'name' => $user['name'], 'api_token' => Str::random(60)],
                ['password' => Hash::make($user['password'])]
            );
        }
    }
}
