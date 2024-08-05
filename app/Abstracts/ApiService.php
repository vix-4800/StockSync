<?php

declare(strict_types=1);

namespace App\Abstracts;

abstract class ApiService
{
    protected array $returnData = [];

    /**
     * Get data from API request
     */
    public function getData(): array
    {
        return $this->returnData;
    }
}
