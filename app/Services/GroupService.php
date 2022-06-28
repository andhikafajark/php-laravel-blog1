<?php

namespace App\Services;

use App\DTO\Request\Group\CreateRequest;
use App\DTO\Request\Group\DeleteRequest;
use App\DTO\Request\IndexRequest;
use App\DTO\Request\ShowRequest;
use App\DTO\Request\Group\UpdateRequest;
use App\DTO\Response\Group\CreateResponse;
use App\DTO\Response\Group\ShowResponse;
use App\DTO\Response\Group\UpdateResponse;

interface GroupService
{
    public function getAll(IndexRequest $indexRequest): array;
    public function create(CreateRequest $createRequest): CreateResponse;
    public function getOne(ShowRequest $showRequest): ShowResponse;
    public function update(UpdateRequest $updateRequest): UpdateResponse;
    public function delete(DeleteRequest $deleteRequest): bool;
}
