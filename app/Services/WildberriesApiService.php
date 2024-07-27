<?php

declare(strict_types=1);

namespace App\Services;

use App\Abstracts\ApiService;
use App\Helpers\Wildberries\WildberriesApiRequest;
use App\Models\MarketplaceAccount;

class WildberriesApiService extends ApiService
{
    private readonly WildberriesApiRequest $request;

    public function __construct(
        private readonly MarketplaceAccount $marketplaceAccount
    ) {
        $this->request = new WildberriesApiRequest($this->marketplaceAccount->api_token);
    }

    /**
     * Получить сборочные задания в поставке.
     * Retrieves the orders for a given supply ID from the Wildberries API.
     *
     * @param  string  $supplyId  The ID of the supply.
     * @return WildberriesApiService Returns the current instance of the class.
     */
    public function ordersForSupply(string $supplyId): WildberriesApiService
    {
        $url = 'https://suppliers-api.wildberries.ru/api/v3/supplies/'.$supplyId.'/orders';

        $this->returnData = $this->request->get($url)['orders'];

        return $this;
    }

    /**
     * Стикеры для поставки.
     * Retrieves stickers for supply from the Wildberries API.
     *
     * @param  string  $type  The type of stickers.
     * @param  int  $width  The width of the stickers.
     * @param  int  $height  The height of the stickers.
     * @param  array  $orders  An array of orders.
     * @return WildberriesApiService Returns the current instance of the class.
     */
    public function stickersForSupply(string $type, int $width, int $height, array $orders): WildberriesApiService
    {
        $url = 'https://suppliers-api.wildberries.ru/api/v3/orders/stickers?type='.$type.'&width='.$width.'&height='.$height;

        $requestBody = [
            'orders' => $orders,
        ];

        $this->returnData = $this->request->post($url, $requestBody)['stickers'];

        return $this;
    }

    /**
     * Остатки на складах.
     * Retrieves the stocks of warehouses from the Wildberries API.
     *
     * @return WildberriesApiService Returns the current instance of the class.
     */
    public function warehousesStocks(): WildberriesApiService
    {
        $url = 'https://statistics-api.wildberries.ru/api/v1/supplier/stocks';

        $queryParams = [
            'dateFrom' => now()->format('Y-m-d'),
        ];

        $this->returnData = $this->request->get($url, $queryParams)['stocks'];

        return $this;
    }
}
