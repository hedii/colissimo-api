<?php

namespace Hedii\ColissimoApi;

use Exception;
use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;

class Parser
{
    /**
     * The colissimo base url.
     *
     * @var string
     */
    private $baseUrl = 'https://www.laposte.fr/particulier/outils/suivre-vos-envois/fr';

    /**
     * The colissimo id.
     *
     * @var string
     */
    private $id;

    /**
     * The crawler instance.
     *
     * @var Crawler
     */
    private $crawler;

    /**
     * The parsed data.
     *
     * @var array
     */
    private $data = [];

    /**
     * Parser constructor.
     *
     * @param string $id
     */
    public function __construct(string $id)
    {
        $this->id = $id;
        $this->crawler = new Crawler();
    }

    /**
     * Run the parser.
     *
     * @return array
     * @throws \Hedii\ColissimoApi\ColissimoApiException
     */
    public function run(): array
    {
        $html = $this->getHtml($this->id);

        if (! $html) {
            return [];
        }

        $this->crawler->addHtmlContent($html);

        $nodeValues = $this->crawler
            ->filter('table tbody tr td')
            ->each(function (Crawler $node) {
                return trim($node->text());
            });

        if ($nodeValues) {
            foreach (array_chunk($nodeValues, 3) as $row) {
                $this->data[] = [
                    'date' => $row[0],
                    'label' => $row[1],
                    'location' => $row[2]
                ];
            }

            return $this->data;
        }

        return [];
    }

    /**
     * Get the html content of the colissimo url response.
     *
     * @param string $id
     * @return null|string
     * @throws \Hedii\ColissimoApi\ColissimoApiException
     */
    private function getHtml(string $id): ?string
    {
        try {
            $response = $this->client()->get("{$this->baseUrl}/{$id}");

            return $response->getBody()->getContents() ?: null;
        } catch (Exception $exception) {
            throw new ColissimoApiException(
                "Cannot get the colissimo url `{{$this->baseUrl}/{$id}}`. {$exception->getMessage()}. See stack trace.",
                $exception->getCode(),
                $exception
            );
        }
    }

    /**
     * Get an http client instance.
     *
     * @return \GuzzleHttp\Client
     */
    private function client(): Client
    {
        return new Client([
            'connect_timeout' => 10,
            'timeout' => 30,
            'verify' => false,
            'headers' => [
                'X-Requested-With' => 'XMLHttpRequest',
                'User-Agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_13_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3396.79 Safari/537.36',
                'Referer' => 'https://www.laposte.fr/particulier/outils/suivre-vos-envois'
            ]
        ]);
    }
}
