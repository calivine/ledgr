<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class IconsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = file_get_contents('database/data.json');
        $json_data = json_decode($json, true);
        foreach($json_data as $index => $icon) {
            DB::table('icons')->insert(
                ['text' => $icon, 'display' => Str::studly($icon)]
            );
        }
    }
}
