<?php

namespace Tests\Feature;

use App\Models\Account;
use App\Models\Transaction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TransferTest extends TestCase
{
    public function test_both_valid(): void
    {
        $srcAccount = Account::find(1);
        $destAccount = Account::find(2);
        $srcBallance = $srcAccount->ballance;
        $destBallance = $destAccount->ballance;
        $response = $this->json('POST', '/api/transfer', [
            'amount' => 2121, 'source' => '6274129005473742', 'destination' => '6104337465312385'
        ]);
        $response->assertStatus(200);
        $this->assertDatabaseHas(Transaction::class, ['source_card_id' => 1, 'dest_card_id' => 3, 'amount' => 2121]);
        $srcAccount->refresh();
        $destAccount->refresh();
        $this->assertEquals($srcBallance - 2121 - 500, $srcAccount->ballance);
        $this->assertEquals($destBallance + 2121, $destAccount->ballance);
    }
}
