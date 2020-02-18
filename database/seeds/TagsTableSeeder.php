<?php

use Illuminate\Database\Seeder;

class TagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tags = [
            'restaurants',
            'video games',
            'digital downloads',
            'alcohol',
            'transfer',
            'gas station',
            'withdrawal',
            'atm'
        ];
    }
}
