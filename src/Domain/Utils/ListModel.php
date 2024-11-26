<?php

declare(strict_types=1);

namespace App\Domain\Utils;

class ListModel
{
    protected array $data;
    protected int $total;

    public function __construct(array $data = [], int $total = 0)
    {
        $this->data = $data;
        $this->total = $total;
    }

    public function getData(): array
    {
        return $this->data;
    }

    public function setData(array $data): void
    {
        $this->data = $data;
    }

    public function getTotal(): int
    {
        return $this->total;
    }

    public function setTotal(int $total): void
    {
        $this->total = $total;
    }
}
