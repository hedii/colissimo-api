<?php

namespace Hedii\ColissimoApi\Tests;

use Hedii\ColissimoApi\ColissimoApi;
use Hedii\ColissimoApi\ColissimoApiException;
use PHPUnit\Framework\TestCase;

class ColissimoApiTest extends TestCase
{
    /**
     * A valid colissimo id.
     *
     * @var string
     */
    private $id = '6H00291144100';

    /**
     * An invalid colissimo id.
     *
     * @var string
     */
    private $invalidId = 'x9V01144112123';

    /**
     * A ColissimoApi instance.
     *
     * @var \Hedii\ColissimoApi\ColissimoApi
     */
    private $colissimo;

    /**
     * This method is called before each test.
     */
    public function setUp(): void
    {
        parent::setUp();

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
