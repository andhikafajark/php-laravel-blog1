<?php

namespace App\Repositories\Impl;

use App\Domain\FilterDomain;
use App\Domain\GroupDomain;
use App\Models\Group;
use App\Repositories\GroupRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class GroupRepositoryImpl extends Repository implements GroupRepository
{
    protected array $allColumnOrder = ['name', 'created_at', 'updated_at'];
    protected array $allColumnSearch = ['name', 'created_at', 'updated_at'];
    protected array $allRelation = [
        'roles' => [
            'reference' => 'group_id',
            'fields' => ['id', 'role_code', 'name', 'is_related', 'user_morph_id', 'created_at', 'updated_at']
        ]
    ];

    public function __construct(Group $group)
    {
        parent::__construct($group);
    }

    /**
     * Get all the resource from DB.
     *
     * @param FilterDomain $filterDomain
     * @return array
     */
    public function getAll(FilterDomain $filterDomain): array
    {
        return match (true) {
            $filterDomain->datatable => $this->__getDatatable($filterDomain),
            default => $this->__getAll($filterDomain)
        };
    }

    /**
     * Create a resource from DB.
     *
     * @param GroupDomain $groupDomain
     * @return GroupDomain
     */
    public function create(GroupDomain $groupDomain): GroupDomain
    {
        $data = $this->model->create($groupDomain->toArray());

        $groupDomain->refresh($data->toArray());

        return $groupDomain;
    }

    /**
     * Get specific resource from DB.
     *
     * @param GroupDomain $groupDomain
     * @param FilterDomain|null $filterDomain
     * @return GroupDomain
     * @throws ModelNotFoundException
     */
    public function getOne(GroupDomain $groupDomain, ?FilterDomain $filterDomain = null): GroupDomain
    {
        $builder = $this->model;

        if ($filterDomain?->relations) {
            $builder = $this->__filterWith($builder, $filterDomain->relations);
        }

        $data = $builder->findOrFail($groupDomain->id);

        $groupDomain->refresh($data->toArray());

        return $groupDomain;
    }

    /**
     * Update specific resource from DB.
     *
     * @param GroupDomain $groupDomain
     * @return GroupDomain
     * @throws ModelNotFoundException
     */
    public function update(GroupDomain $groupDomain): GroupDomain
    {
        $this->model
            ->findOrFail($groupDomain->id)
            ->update($groupDomain->toArray());

        $data = $this->model->findOrFail($groupDomain->id);

        $groupDomain->refresh($data->toArray());

        return $groupDomain;
    }

    /**
     * Delete specific resource from DB.
     *
     * @param GroupDomain $groupDomain
     * @return bool
     * @throws ModelNotFoundException
     */
    public function delete(GroupDomain $groupDomain): bool
    {
        return $this->model->findOrFail($groupDomain->id)->delete();
    }
}
