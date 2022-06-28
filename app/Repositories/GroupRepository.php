<?php

namespace App\Repositories;

use App\Domain\FilterDomain;
use App\Domain\GroupDomain;

interface GroupRepository
{
    public function getAll(FilterDomain $filterDomain): array;
    public function create(GroupDomain $groupDomain): GroupDomain;
    public function getOne(GroupDomain $groupDomain, ?FilterDomain $filterDomain = null): GroupDomain;
    public function update(GroupDomain $groupDomain): GroupDomain;
    public function delete(GroupDomain $groupDomain): bool;
}
