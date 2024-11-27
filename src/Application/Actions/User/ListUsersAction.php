<?php

declare(strict_types=1);

namespace App\Application\Actions\User;

use App\Domain\Utils\Pagination;
use Psr\Http\Message\ResponseInterface as Response;

class ListUsersAction extends UserAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $param = $this->request->getQueryParams();

        $pagination = new Pagination();
        if (isset($param['Page']) && isset($param['PageSize'])) {
            $pagination->setPage((int) $param['Page']);
            $pagination->setPageSize((int) $param['PageSize']);
        }

        $users = $this->userRepository->getUsersByPagination($pagination);

        $this->logger->info('Users list was viewed.');

        return $this->respondWithData($users);
    }
}
