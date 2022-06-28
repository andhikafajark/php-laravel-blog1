<?php

namespace App\Observers;

use App\Helpers\LogHelper;
use App\Models\BlogCategory;
use Illuminate\Support\Str;

class BlogCategoryObserver
{
    private string $title = 'Blog Category';

    /**
     * Listen to the BlogCategory "creating" event.
     *
     * @param BlogCategory $blogCategory
     * @return void
     */
    public function creating(BlogCategory $blogCategory): void
    {
        $blogCategory->id = Str::uuid()->toString();
    }

    /**
     * Handle the BlogCategory "created" event.
     *
     * @param BlogCategory $blogCategory
     * @return void
     */
    public function created(BlogCategory $blogCategory): void
    {
        LogHelper::auditTrailDetail($this->title, 'create', null, $blogCategory->refresh()->toArray());
    }

    /**
     * Listen to the BlogCategory "updating" event.
     *
     * @param BlogCategory $blogCategory
     * @return void
     */
    public function updating(BlogCategory $blogCategory): void
    {
        LogHelper::$oldData = (clone $blogCategory)->refresh()->toArray();
    }

    /**
     * Handle the BlogCategory "updated" event.
     *
     * @param BlogCategory $blogCategory
     * @return void
     */
    public function updated(BlogCategory $blogCategory): void
    {
        LogHelper::auditTrailDetail($this->title, 'update', LogHelper::$oldData, $blogCategory->toArray());
    }

    /**
     * Handle the BlogCategory "deleted" event.
     *
     * @param BlogCategory $blogCategory
     * @return void
     */
    public function deleted(BlogCategory $blogCategory): void
    {
        LogHelper::auditTrailDetail($this->title, 'delete', $blogCategory->toArray());
    }
}
