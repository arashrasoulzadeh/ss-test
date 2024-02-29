<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('cards')->insert([
            'account_id' => 1,
            'number' => '6274129005473742'
        ]);
        DB::table('cards')->insert([
            'account_id' => 1,
            'number' => '6104338978668818'
        ]);
        DB::table('cards')->insert([
            'account_id' => 2,
            'number' => '6104337465312385            '
        ]);
        DB::table('cards')->insert([
            'account_id' => 2,
            'number' => '6104337792509034            '
        ]);
    }
}
