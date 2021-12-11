<?php

namespace Hedii\ColissimoApi\Tests;

use Hedii\ColissimoApi\ColissimoApi;
use Hedii\ColissimoApi\ColissimoApiException;
use PHPUnit\Framework\TestCase;

class ColissimoApiTest extends TestCase
{
    private string $invalidId = 'x9V01144112123';

    private ColissimoApi $colissimo;

    public function setUp(): void
    {
        parent::setUp();

        $this->id = getenv('COLISSIMO_ID');

        $this->colissimo = new ColissimoApi();
    }

    /** @test */
    public function it_should_fail_on_wrong_id(): void
    {
        $this->expectException(ColissimoApiException::class);
        $this->expectExceptionMessage('Bad Request');

        $this->colissimo->get($this->invalidId);
    }

    /** @test */
    public function it_should_have_an_all_method(): void
    {
        $result = $this->colissimo->get($this->id);

        $this->assertArrayHasKey('lang', $result);
        $this->assertArrayHasKey('scope', $result);
        $this->assertArrayHasKey('shipment', $result);
        $this->assertArrayHasKey('timeline', $result['shipment']);
    }
}
