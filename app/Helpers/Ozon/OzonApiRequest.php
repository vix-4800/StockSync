<?php

declare(strict_types=1);

namespace App\Helpers\Ozon;

use App\Abstracts\AbstractApiRequest;
use Illuminate\Support\Facades\Http;

final class OzonApiRequest extends AbstractApiRequest
{
    /**
     * Api Request Constructor.
     */
    public function __construct(
        private readonly string $userId,
        private readonly string $apiToken,
    ) {
        $this->request = Http::withoutVerifying()
            ->withHeaders([
                'Client-Id' => $this->userId,
                'Api-Key' => $this->apiToken,
                'Content-Type' => 'application/json',
            ]);
    }

    /**
     * Send GET request to Ozon API
     *
     * @throws OzonApiRequestException
     */
    public function get(string $url, array $queryParams = []): array
    {
        $url = $this->prepareUrl($url, $queryParams);

        $response = $this->request->get($url);
        // throw_if($response->failed(), new OzonApiRequestException('Failed to get data from Ozon API'));

        return $response->json();
    }

    /**
     * Send POST request to Ozon API
     *
     * @throws OzonApiRequestException
     */
    public function post(string $url, array $data): array
    {
        $response = $this->request->post($url, $data);
        // throw_if($response->failed(), new OzonApiRequestException('Failed to get data from Ozon API'));

        return $response->json();
    }
}
