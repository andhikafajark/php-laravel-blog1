<?php

namespace App\Observers;

use App\Helpers\LogHelper;
use App\Models\Blog;
use Illuminate\Support\Str;

class BlogObserver
{
    private string $title = 'Blog';

    /**
     * Listen to the Blog "creating" event.
     *
     * @param Blog $blog
     * @return void
     */
    public function creating(Blog $blog): void
    {
        $blog->id = Str::uuid()->toString();
    }

    /**
     * Handle the Blog "created" event.
     *
     * @param Blog $blog
     * @return void
     */
    public function created(Blog $blog): void
    {
        LogHelper::auditTrailDetail($this->title, 'create', null, $blog->refresh()->toArray());
    }

    /**
     * Listen to the Blog "updating" event.
     *
     * @param Blog $blog
     * @return void
     */
    public function updating(Blog $blog): void
    {
        LogHelper::$oldData = (clone $blog)->refresh()->toArray();
    }

    /**
     * Handle the Blog "updated" event.
     *
     * @param Blog $blog
     * @return void
     */
    public function updated(Blog $blog): void
    {
        LogHelper::auditTrailDetail($this->title, 'update', LogHelper::$oldData, $blog->toArray());
    }

    /**
     * Handle the Blog "deleted" event.
     *
     * @param Blog $blog
     * @return void
     */
    public function deleted(Blog $blog): void
    {
        LogHelper::auditTrailDetail($this->title, 'delete', $blog->toArray());
    }
}
