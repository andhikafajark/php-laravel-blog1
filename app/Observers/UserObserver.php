<?php

namespace App\Observers;

use App\Helpers\LogHelper;
use App\Models\User;
use Illuminate\Support\Str;

class UserObserver
{
    private string $title = 'User';

    /**
     * Listen to the User "creating" event.
     *
     * @param User $user
     * @return void
     */
    public function creating(User $user): void
    {
        $user->id = Str::uuid()->toString();
    }

    /**
     * Handle the User "created" event.
     *
     * @param User $user
     * @return void
     */
    public function created(User $user): void
    {
        LogHelper::auditTrailDetail($this->title, 'create', null, $user->refresh()->toArray());
    }

    /**
     * Listen to the User "updating" event.
     *
     * @param User $user
     * @return void
     */
    public function updating(User $user): void
    {
        LogHelper::$oldData = (clone $user)->refresh()->toArray();
    }

    /**
     * Handle the User "updated" event.
     *
     * @param User $user
     * @return void
     */
    public function updated(User $user): void
    {
        LogHelper::auditTrailDetail($this->title, 'update', LogHelper::$oldData, $user->toArray());
    }

    /**
     * Handle the User "deleted" event.
     *
     * @param User $user
     * @return void
     */
    public function deleted(User $user): void
    {
        LogHelper::auditTrailDetail($this->title, 'delete', $user->toArray());
    }
}
