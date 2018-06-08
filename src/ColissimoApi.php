<?php

namespace Hedii\ColissimoApi;

class ColissimoApi
{
    /**
     * Get the colissimo status.
     *
     * @param string $id
     * @return array
     * @throws \Hedii\ColissimoApi\ColissimoApiException
     */
    public function get(string $id): array
    {
        $data = (new Parser($id))->run();

        if (empty($data)) {
            throw new ColissimoApiException("Cannot find status for colissimo id `{$id}`");
        }

        return $data;
    }
}
