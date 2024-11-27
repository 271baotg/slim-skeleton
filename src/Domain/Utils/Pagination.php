<?php

declare(strict_types=1);

namespace App\Domain\Utils;

use JsonSerializable;

class Pagination implements JsonSerializable
{
    private int $page = 1;
    private int $pageSize = 5;
    private int $maxPageSize = 50;

    public function getPage(): int
    {
        return $this->page;
    }

    public function setPage(int $page)
    {
        $this->page = $page;
    }

    public function getPageSize(): int
    {
        return $this->pageSize;
    }

    public function setPageSize(int $pageSize)
    {
        $this->pageSize = $pageSize;
    }

    public static function validate(
        Pagination $pagination,
        int $defaultPageNumber = 1,
        int $defaultPageSize = 10,
        int $defaultMaxPageSize = 50,
    ): Pagination {
        if ($pagination == null) {
            $pagination = new Pagination();
            $pagination->page = $defaultPageNumber;
            $pagination->pageSize = $defaultPageSize;
            return $pagination;
        }

        if ($pagination->page < 1) {
            $pagination->page = $defaultPageNumber;
        }

        if (
            $pagination->pageSize < 1 ||
            $pagination->pageSize > $defaultMaxPageSize
        ) {
            $pagination->pageSize = $defaultPageSize;
        }

        return $pagination;
    }

    public function jsonSerialize(): mixed
    {
        return [
            'page' => $this->page,
            'pageSize' => $this->pageSize,
            'maxPageSize' => $this->maxPageSize,
        ];
    }
}
