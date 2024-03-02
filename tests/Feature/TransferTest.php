<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TransferTest extends TestCase
{
    public function test_source_is_valid(): void
    {
        $response = $this->json('POST', '/api/transfer', [
            'amount' => 1000, 'source' => '6274129005473742', 'destination' => '6104337465312385'
        ]);
        $response->assertStatus(200);
    }
}
