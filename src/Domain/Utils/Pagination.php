<?php

declare(strict_types=1);

namespace App\Domain\Utils;

class Pagination
{
    private int $page = 1;
    private int $pageSize = 5;
    private int $maxPageSize = 50;

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
    }
}
