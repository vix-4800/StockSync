<?php

declare(strict_types=1);

namespace App\Helpers\Wildberries;

final class WildberriesApiResponse
{
    public function __construct(
        private readonly ?array $data,
        private readonly ?int $code,
        private readonly ?string $message,
        private readonly ?string $details
    ) {
        //
    }

    public function getData(): ?array
    {
        return $this->data;
    }

    public function getCode(): ?int
    {
        return $this->code;
    }

    public function isSuccessful(): bool
    {
        return $this->code === 200;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function getDetails(): ?string
    {
        return $this->details;
    }
}
