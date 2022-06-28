<?php

namespace App\Providers;

use App\Models\AuditTrail;
use App\Models\AuditTrailDetail;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\User;
use App\Observers\AuditTrailDetailObserver;
use App\Observers\AuditTrailObserver;
use App\Observers\BlogCategoryObserver;
use App\Observers\BlogObserver;
use App\Observers\UserObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * The model observers for your application.
     *
     * @var array
     */
    protected $observers = [
        AuditTrail::class => [AuditTrailObserver::class],
        AuditTrailDetail::class => [AuditTrailDetailObserver::class],
        BlogCategory::class => [BlogCategoryObserver::class],
        Blog::class => [BlogObserver::class],
        User::class => [UserObserver::class]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
