<?php

use Illuminate\Database\Seeder;

class CampgroundsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 16; $i++) {
            DB::table("campgrounds")->insert([
                ['name' => '숲속의 집', 'number' => $i + 1],
            ]);
        }

        for ($i = 0; $i < 16; $i++) {
            DB::table("campgrounds")->insert([
                ['name' => '오토갬핑장', 'number' => $i + 1],
            ]);
        }
    }
}
