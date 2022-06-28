<?php

namespace App\Repositories\Impl;

use App\Domain\FilterDomain;
use App\Domain\UserDomain;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UserRepositoryImpl extends Repository implements UserRepository
{
    protected array $allColumnOrder = ['name', 'username', 'gender', 'is_active', 'created_at', 'updated_at'];
    protected array $allColumnSearch = ['name', 'username', 'gender', 'created_at', 'updated_at'];
    protected array $allRelation = [
        'self' => [
            'conditions' => [
                'where' => ['gender', 'is_active']
            ]
        ],
        'userProfiles' => [
            'reference' => 'user_id',
            'fields' => ['id', 'name', 'is_default', 'created_at', 'updated_at']
        ]
    ];

    public function __construct(User $user)
    {
        parent::__construct($user);
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
     * @param UserDomain $userDomain
     * @return UserDomain
     */
    public function create(UserDomain $userDomain): UserDomain
    {
        $data = $this->model->create($userDomain->toArray());

        $userDomain->refresh($data->toArray());

        return $userDomain;
    }

    /**
     * Get specific resource from DB.
     *
     * @param UserDomain $userDomain
     * @param FilterDomain|null $filterDomain
     * @return UserDomain
     * @throws ModelNotFoundException
     */
    public function getOne(UserDomain $userDomain, ?FilterDomain $filterDomain = null): UserDomain
    {
        $builder = $this->model;

        if ($filterDomain?->relations) {
            $builder = $this->__filterWith($builder, $filterDomain->relations);
        }

        $data = $builder->findOrFail($userDomain->id);

        $userDomain->refresh($data->toArray());

        return $userDomain;
    }

    /**
     * Update specific resource from DB.
     *
     * @param UserDomain $userDomain
     * @return UserDomain
     * @throws ModelNotFoundException
     */
    public function update(UserDomain $userDomain): UserDomain
    {
        $this->model
            ->findOrFail($userDomain->id)
            ->update($userDomain->toArray());

        $data = $this->model->findOrFail($userDomain->id);

        $userDomain->refresh($data->toArray());

        return $userDomain;
    }

    /**
     * Delete specific resource from DB.
     *
     * @param UserDomain $userDomain
     * @return bool
     * @throws ModelNotFoundException
     */
    public function delete(UserDomain $userDomain): bool
    {
        return $this->model->findOrFail($userDomain->id)->delete();
    }
}
