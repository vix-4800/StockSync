<?php

declare(strict_types=1);

namespace App\Helpers\Wildberries;

use App\Abstracts\AbstractApiRequest;
use Illuminate\Support\Facades\Http;

final class WildberriesApiRequest extends AbstractApiRequest
{
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
     *
     * @throws WildberriesApiRequestException
     */
    public function get(string $url, array $queryParams = []): array
    {
        $url = $this->prepareUrl($url, $queryParams);

        $response = $this->request->get($url);
        // throw_if($response->failed(), new WildberriesApiRequestException('Failed to get data from Wildberries API'));

        return $response->json();
    }

    /**
     * Make POST request to Wildberries API
     *
     * @throws WildberriesApiRequestException
     */
    public function post(string $url, array $data): array
    {
        $response = $this->request->post($url, $data);
        // throw_if($response->failed(), new WildberriesApiRequestException('Failed to post data to Wildberries API'));

        return $response->json();
    }
}
