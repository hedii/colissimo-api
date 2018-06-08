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
    private $id = '8N04104266553';

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
        $this->expectExceptionMessage("Cannot find status for colissimo id `{$this->invalidId}`");

        $this->colissimo->get($this->invalidId);
    }

    /** @test */
    public function it_should_have_an_all_method(): void
    {
        $result = $this->colissimo->get($this->id);

        $this->assertSame([
            [
                'date' => '30/05/2018',
                'label' => 'Votre colis est livré.',
                'location' => 'Centre Courrier 75'
            ], [
                'date' => '30/05/2018',
                'label' => 'Votre colis est en préparation pour la livraison.',
                'location' => 'Centre Courrier 75'
            ], [
                'date' => '30/05/2018',
                'label' => 'Votre colis est arrivé sur son site de distribution',
                'location' => 'Centre Courrier 75'
            ], [
                'date' => '29/05/2018',
                'label' => 'Votre colis est en cours d\'acheminement.',
                'location' => 'Plateforme Colis'
            ], [
                'date' => '28/05/2018',
                'label' => 'Votre colis a été déposé après l\'heure limite de dépôt. Il sera expédié dès le prochain jour ouvré.',
                'location' => 'Bureau de Poste Les estables'
            ]
        ], $result);
    }
}
