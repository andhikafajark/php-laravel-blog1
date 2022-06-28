<?php

namespace App\Repositories;

use App\Domain\FilterDomain;
use App\Domain\UserDomain;

interface UserRepository
{
    public function getAll(FilterDomain $filterDomain): array;
    public function create(UserDomain $userDomain): UserDomain;
    public function getOne(UserDomain $userDomain, ?FilterDomain $filterDomain = null): UserDomain;
    public function update(UserDomain $userDomain): UserDomain;
    public function delete(UserDomain $userDomain): bool;
}
