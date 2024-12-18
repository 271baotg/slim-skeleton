<?php

declare(strict_types=1);

namespace App\Application\Actions\User;

use App\Domain\Utils\Pagination;
use Psr\Http\Message\ResponseInterface as Response;

use Swagger\Annotations as SWG;

class ListUsersAction extends UserAction
{
    /**
     * @OA\Get(
     *   tags={"user"},
     *   path="/users/{id}",
     *   operationId="getUser",
     *   @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          description="User id",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="A single user",
     *     @OA\JsonContent(ref="#/components/schemas/User")
     *   )
     * )
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
