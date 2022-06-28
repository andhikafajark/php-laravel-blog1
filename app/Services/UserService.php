<?php

namespace App\Services;

use App\DTO\Request\User\CreateRequest;
use App\DTO\Request\User\DeleteRequest;
use App\DTO\Request\IndexRequest;
use App\DTO\Request\ShowRequest;
use App\DTO\Request\User\UpdateRequest;
use App\DTO\Response\User\CreateResponse;
use App\DTO\Response\User\ShowResponse;
use App\DTO\Response\User\UpdateResponse;

interface UserService
{
    public function getAll(IndexRequest $indexRequest): array;
    public function create(CreateRequest $createRequest): CreateResponse;
    public function getOne(ShowRequest $showRequest): ShowResponse;
    public function update(UpdateRequest $updateRequest): UpdateResponse;
    public function delete(DeleteRequest $deleteRequest): bool;
}
