<?php

namespace Marshmallow\Blogs\Models;

use Marshmallow\Sluggable\HasSlug;
use Illuminate\Database\Eloquent\Model;
use Marshmallow\Seoable\Traits\Seoable;
use Illuminate\Database\Eloquent\Builder;
use Marshmallow\Seoable\Traits\SeoSitemapTrait;

class BlogTag extends Model
{
    use Seoable;
    use HasSlug;
    use SeoSitemapTrait;

    public function route()
    {
        return route(config('blogs.routes.blog_tags'), $this);
    }

    public function blogs()
    {
        return $this->belongsToMany(config('blogs.model.blog'));
    }

    /**
     * Get the Page url by item
     *
     * @return string
     */
    public function getSitemapItemUrl(): string
    {
        return $this->route();
    }

    /**
     * Query all the Page items which should be
     * part of the sitemap (crawlable for google).
     *
     * @return Builder
     */
    public static function getSitemapItems()
    {
        return static::get();
    }
}
