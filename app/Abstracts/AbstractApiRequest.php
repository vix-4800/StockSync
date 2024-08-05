<?php

declare(strict_types=1);

namespace App\Abstracts;

use Illuminate\Http\Client\PendingRequest;

abstract class AbstractApiRequest
{
    protected PendingRequest $request;

    /**
     * Make GET request to API
     *
     * @throws \Exception
     */
    abstract public function get(string $url, array $queryParams = []): array;

    /**
     * Make POST request to API
     *
     * @throws \Exception
     */
    abstract public function post(string $url, array $data): array;

    /**
     * Prepare URL
     */
    protected function prepareUrl(string $url, array $queryParams = []): string
    {
        if (! empty($queryParams)) {
            $url .= '?'.http_build_query($queryParams);
        }

        return $url;
    }
}
