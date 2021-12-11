<?php

namespace Hedii\ColissimoApi;

use GuzzleHttp\Client;
use GuzzleHttp\Cookie\SetCookie;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException;
use Throwable;

class ColissimoApi
{
    private Client $client;

    public function __construct(int $connectionTimeout = 10, int $timeout = 30, bool $verify = false)
    {
        $this->client = new Client([
            'connect_timeout' => $connectionTimeout,
            'timeout' => $timeout,
            'verify' => $verify,
        ]);
    }

    /**
     * Get the colissimo status.
     *
     * @throws \Hedii\ColissimoApi\ColissimoApiException
     */
    public function get(string $id): array
    {
        try {
            $response = $this->client->get("https://api.laposte.fr/ssu/v1/suivi-unifie/idship/{$id}", [
                'query' => ['lang' => 'fr_FR'],
                'headers' => [
                    'Accept' => 'application/json',
                    'referer' => "https://www.laposte.fr/outils/suivre-vos-envois?code={$id}",
                    'Origin' => 'https://www.laposte.fr',
                    'Authorization' => "Bearer {$this->getToken($id)}",
                ],
            ]);

            return json_decode($response->getBody()->getContents(), associative: true);
        } catch (ClientException $exception) {
            throw new ColissimoApiException(
                $exception->getResponse()->getReasonPhrase(),
                $exception->getResponse()->getStatusCode()
            );
        } catch (RequestException $exception) {
            if ($exception->hasResponse()) {
                throw new ColissimoApiException(
                    $exception->getResponse()->getReasonPhrase(),
                    $exception->getResponse()->getStatusCode()
                );
            } else {
                throw new ColissimoApiException(
                    isset($exception->getHandlerContext()['errno'])
                        ? curl_strerror($exception->getHandlerContext()['errno'])
                        : $exception->getMessage()
                );
            }
        } catch (Throwable $exception) {
            throw new ColissimoApiException($exception->getMessage(), 1, $exception);
        }
    }

    /**
     * Get the JWT token.
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    private function getToken(string $id): string
    {
        $response = $this->client->get("https://www.laposte.fr/outils/suivre-vos-envois?code={$id}");

        return SetCookie::fromString($response->getHeader('Set-Cookie')[0])->getValue();
    }
}
