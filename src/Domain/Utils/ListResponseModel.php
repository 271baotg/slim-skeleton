<?php

declare(strict_types=1);

namespace App\Domain\Utils;

use JsonSerializable;

class ListResponseModel implements JsonSerializable
{
    protected array $data;
    protected int $total;
    protected Pagination $pagination;

    public function __construct(array $data = [], int $total = 0)
    {
        $this->data = $data;
        $this->total = $total;
        $this->pagination = new Pagination();
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

    public function setPagination(Pagination $pagination): void
    {
        $this->pagination = $pagination;
    }

    public function jsonSerialize(): mixed
    {
        return [
            'pagination' => $this->pagination,
            'result' => $this->data,
            'total' => $this->total,
        ];
    }
}
