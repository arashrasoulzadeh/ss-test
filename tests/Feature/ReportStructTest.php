<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReportStructTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_report_valid_struct(): void
    {
        $response = $this->json('GET', '/api/report');
        $response->assertJsonStructure([['name', 'email', 'total', 'last_10_transactions' => [['id', 'amount', 'fee', 'created_at', 'source' => ['number'], 'dest' => ['number']]]]]);
        $response->assertStatus(200);
    }
}
