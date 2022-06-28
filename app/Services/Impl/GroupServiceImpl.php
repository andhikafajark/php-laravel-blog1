<?php

namespace App\Services\Impl;

use App\Domain\FilterDomain;
use App\Domain\GroupDomain;
use App\DTO\Request\Group\CreateRequest;
use App\DTO\Request\Group\DeleteRequest;
use App\DTO\Request\IndexRequest;
use App\DTO\Request\ShowRequest;
use App\DTO\Request\Group\UpdateRequest;
use App\DTO\Response\Group\CreateResponse;
use App\DTO\Response\Group\ShowResponse;
use App\DTO\Response\Group\UpdateResponse;
use App\Repositories\GroupRepository;
use App\Services\GroupService;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class GroupServiceImpl implements GroupService
{
    public function __construct(private GroupRepository $groupRepository)
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

        return $this->groupRepository->getAll($filterDomain);
    }

    /**
     * Create a resource.
     *
     * @param CreateRequest $createRequest
     * @return CreateResponse
     */
    public function create(CreateRequest $createRequest): CreateResponse
    {
        $groupDomain = new GroupDomain($createRequest->toArray());

        $groupDomain = $this->groupRepository->create($groupDomain);

        return new CreateResponse($groupDomain->toArray());
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
        $groupDomain = new GroupDomain($showRequest->toArray());
        $filterDomain = new FilterDomain($showRequest->toArray());

        $groupDomain = $this->groupRepository->getOne($groupDomain, $filterDomain);

        return new ShowResponse($groupDomain->toArray());
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
        $groupDomain = new GroupDomain($updateRequest->toArray());

        $groupDomain = $this->groupRepository->update($groupDomain);

        return new UpdateResponse($groupDomain->toArray());
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
        $groupDomain = new GroupDomain($deleteRequest->toArray());

        return $this->groupRepository->delete($groupDomain);
    }
}
