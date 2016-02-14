<?php

namespace Hedii\ColissimoApi;

use Symfony\Component\DomCrawler\Crawler;

class Parser
{
    /**
     * @var Crawler
     */
    private $crawler;

    /**
     * @var string
     */
    private $baseUrl = 'http://www.colissimo.fr/portail_colissimo/suivre.do?colispart=';

    /**
     * @var string
     */
    private $id;

    /**
     * @var array
     */
    private $dates = [];

    /**
     * @var array
     */
    private $labels = [];

    /**
     * @var array
     */
    private $sites = [];

    /**
     * @var array
     */
    private $data = [];

    /**
     * Parser constructor.
     *
     * @param string $id
     */
    public function __construct($id)
    {
        $this->id      = $id;
        $this->crawler = new Crawler();
    }

    /**
     * @return array|bool
     */
    public function parseAll()
    {
        $this->crawler->addHtmlContent($this->getHtml($this->id), 'ISO-8859-1');

        $nodeValues = $this->crawler->filter('table.dataArray tbody tr td')->each(function (Crawler $node) {
            return [
                $node->attr('headers') => trim($node->text())
            ];
        });

        if ($nodeValues) {
            $rows = array_chunk($nodeValues, 3);

            foreach ($rows as $key => $value) {
                $this->dates[$key]  = $value[0];
                $this->labels[$key] = $value[1];
                $this->sites[$key]  = $value[2];
            }

            foreach ($this->dates as $key => $value) {
                $this->data['status'][$key] = [
                    'date'     => $this->dates[$key]['Date'],
                    'label'    => $this->labels[$key]['Libelle'],
                    'location' => $this->sites[$key]['site']
                ];
            }

            $this->data['id']          = $this->id;
            $this->data['destination'] = $this->parseDestination();

            return $this->data;
        }

        return false;
    }

    /**
     * @param string $id
     *
     * @return string
     */
    private function getHtml($id)
    {
        return file_get_contents($this->baseUrl . $id);
    }

    /**
     * @return mixed
     */
    private function parseDestination()
    {
        return preg_replace('/^[\pZ\pC]+|[\pZ\pC]+$/u', '',
            $this->getStringAfter($this->crawler->filter('.suivreForm .head')->text(), 'à destination de :'));
    }

    /**
     * @param string $haystack
     * @param string $delimiter
     *
     * @return mixed|string|bool
     */
    private function getStringAfter($haystack, $delimiter)
    {
        if ( ! empty($haystack) && ! empty($delimiter)) {
            if (strpos($haystack, $delimiter) !== false) {
                $filter = explode($delimiter, $haystack);

                if (isset($filter[1])) {
                    return $filter[1];
                }

                return false;
            }

            return false;
        }

        return false;
    }
}