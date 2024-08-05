<?php

declare(strict_types=1);

namespace App\Helpers\Wildberries;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;

final class WildberriesApiRequest
{
    protected PendingRequest $request;

    /**
     * Api Request Constructor.
     */
    public function __construct(
        private readonly string $apiToken,
    ) {
        $this->request = Http::withoutVerifying()
            ->withHeaders([
                'Content-Type' => 'application/json',
                'Authorization' => $this->apiToken,
            ]);
    }

    /**
     * Make GET request to Wildberries API
     */
    public function get(string $url, array $queryParams = []): array
    {
        $url = $this->prepareUrl($url, $queryParams);

        $response = $this->request->get($url);

        return $response->json();
    }

    /**
     * Make POST request to Wildberries API
     */
    public function post(string $url, array $data): WildberriesApiResponse
    {
        $response = $this->request->post($url, $data);

        $apiResponse = null;
        if ($response->failed()) {
            $apiResponse = new WildberriesApiResponse(null, $response->status(), null, null);
        } else {
            if ($response->successful()) {
                $apiResponse = new WildberriesApiResponse($response->json(), $response->status(), null, null);
            } else {
                $apiResponse = new WildberriesApiResponse(null, $response->status(), $response->json('title'), $response->json('detail'));
            }
        }

        return $apiResponse;
    }

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
