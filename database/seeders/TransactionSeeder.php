<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 10; $i++) {
            DB::table('transactions')->insert([
                'source_card_id' => 1,
                'dest_card_id' => 3,
                'amount' => fake()->numberBetween(1000, 10000),
                'fee' => 500
            ]);
            DB::table('transactions')->insert([
                'source_card_id' => 1,
                'dest_card_id' => 4,
                'amount' => fake()->numberBetween(1000, 10000),
                'fee' => 500
            ]);
            DB::table('transactions')->insert([
                'source_card_id' => 4,
                'dest_card_id' => 2,
                'amount' => fake()->numberBetween(1000, 10000),
                'fee' => 500
            ]);
            DB::table('transactions')->insert([
                'source_card_id' => 3,
                'dest_card_id' => 2,
                'amount' => fake()->numberBetween(1000, 10000),
                'fee' => 500
            ]);
        }
    }
}
