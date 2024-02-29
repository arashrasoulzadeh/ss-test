<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TransferReqeustTest extends TestCase
{

    public function test_source_is_valid(): void
    {
        $response = $this->json('POST', '/api/transfer', [
            'amount' => 1000, 'source' => '6274129005473742', 'destination' => '6104337465312381'
        ]);
        $response->assertStatus(422);
        $response->assertJsonFragment(["destination" => [
            "invalid card"
        ]]);
    }
    public function test_destination_is_valid(): void
    {
        $response = $this->json('POST', '/api/transfer', [
            'amount' => 1000, 'source' => '6274129005473740', 'destination' => '6104337465312385'
        ]);
        $response->assertStatus(422);
        $response->assertJsonFragment(["source" => [
            "invalid card"
        ]]);
    }
    public function test_both_invalid(): void
    {
        $response = $this->json('POST', '/api/transfer', [
            'amount' => 1000, 'source' => '6274129005473740', 'destination' => '6274129005473740'
        ]);
        $response->assertStatus(422);
        $response->assertJsonFragment(["source" => [
            "invalid card"
        ]]);
        $response->assertJsonFragment(["destination" => [
            "invalid card"
        ]]);
    }
}
