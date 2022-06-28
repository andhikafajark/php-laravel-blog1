<?php

namespace App\Providers;

//use App\Models\Group;
use App\Repositories\GroupRepository;
use App\Repositories\Impl\GroupRepositoryImpl;
use App\Services\GroupService;
use App\Services\Impl\GroupServiceImpl;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class GroupServiceProvider extends ServiceProvider implements DeferrableProvider
{
    public array $singletons = [
//        Group::class => Group::class,
        GroupRepository::class => GroupRepositoryImpl::class,
        GroupService::class => GroupServiceImpl::class,
    ];

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides(): array
    {
        return [
//            Group::class,
            GroupRepository::class,
            GroupService::class
        ];
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(): void
    {
        //
    }
}
