<?php

namespace App\Services\Impl;

use App\Domain\FilterDomain;
use App\Domain\UserDomain;
use App\DTO\Request\User\CreateRequest;
use App\DTO\Request\User\DeleteRequest;
use App\DTO\Request\IndexRequest;
use App\DTO\Request\ShowRequest;
use App\DTO\Request\User\UpdateRequest;
use App\DTO\Response\User\CreateResponse;
use App\DTO\Response\User\ShowResponse;
use App\DTO\Response\User\UpdateResponse;
use App\Repositories\UserRepository;
use App\Services\UserService;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UserServiceImpl implements UserService
{
    public function __construct(private UserRepository $userRepository)
    {
    }

    /**
     * Get all the resource.
     *
     * @param IndexRequest $indexRequest
     * @return array
     */
    public function getAll(IndexRequest $indexRequest): array
    {
        $filterDomain = new FilterDomain($indexRequest->toArray());

        return $this->userRepository->getAll($filterDomain);
    }

    /**
     * Create a resource.
     *
     * @param CreateRequest $createRequest
     * @return CreateResponse
     */
    public function create(CreateRequest $createRequest): CreateResponse
    {
        $userDomain = new UserDomain($createRequest->toArray());

        $userDomain = $this->userRepository->create($userDomain);

        return new CreateResponse($userDomain->toArray());
    }

    /**
     * Get specific resource.
     *
     * @param ShowRequest $showRequest
     * @return ShowResponse
     * @throws ModelNotFoundException
     */
    public function getOne(ShowRequest $showRequest): ShowResponse
    {
        $userDomain = new UserDomain($showRequest->toArray());
        $filterDomain = new FilterDomain($showRequest->toArray());

        $userDomain = $this->userRepository->getOne($userDomain, $filterDomain);

        return new ShowResponse($userDomain->toArray());
    }


    /**
     * Update specific resource.
     *
     * @param UpdateRequest $updateRequest
     * @return UpdateResponse
     * @throws ModelNotFoundException
     */
    public function update(UpdateRequest $updateRequest): UpdateResponse
    {
        $userDomain = new UserDomain($updateRequest->toArray());

        $userDomain = $this->userRepository->update($userDomain);

        return new UpdateResponse($userDomain->toArray());
    }

    /**
     * Delete specific resource.
     *
     * @param DeleteRequest $deleteRequest
     * @return bool
     * @throws ModelNotFoundException
     */
    public function delete(DeleteRequest $deleteRequest): bool
    {
        $userDomain = new UserDomain($deleteRequest->toArray());

        return $this->userRepository->delete($userDomain);
    }
}
