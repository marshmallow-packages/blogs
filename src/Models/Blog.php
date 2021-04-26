<?php

namespace Marshmallow\Blogs\Models;

use Marshmallow\Sluggable\HasSlug;
use Illuminate\Database\Eloquent\Model;
use Marshmallow\Seoable\Traits\Seoable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Marshmallow\Seoable\Traits\SeoSitemapTrait;
use Marshmallow\Nova\Flexible\Casts\FlexibleCast;

class Blog extends Model
{
    use HasSlug;
    use Seoable;
    use SeoSitemapTrait;

    protected $casts = [
        'publish_date' => 'datetime',
        'content' => FlexibleCast::class,
    ];

    public function route()
    {
        return route(config('blogs.routes.blog'), [
            'blogTag' => $this->tag,
            'blog' => $this,
        ]);
    }

    public function dateFormatted()
    {
        return $this->publish_date->format(config('blogs.publish_date_format'));
    }

    public function getImage($column = 'overview_image')
    {
        return asset('storage/' . $this->{$column});
    }

    public function scopeOrdered(Builder $builder)
    {
        $builder->orderBy('publish_date', 'desc');
    }

    public function scopePublished(Builder $builder)
    {
        $builder->whereDate('publish_date', '<', now());
    }

    public function scopeIgnoreTags(Builder $builder, Collection $tags)
    {
        $builder->whereNotIn('blogs.blog_tag_id', $tags->pluck('id')->toArray());
    }

    public function scopeFiltered(Builder $builder)
    {
        if (request()->has('q')) {
            $like = '%' . request()->q . '%';
            $builder->where(function ($query) use ($like) {
                $query->where('name', 'LIKE', $like)
                    ->orWhere('intro', 'LIKE', $like)
                    ->orWhere('content', 'LIKE', $like);
            });
        }
    }

    public function scopeTagged(Builder $builder, BlogTag $tag)
    {
        $builder->published()->where('blog_tag_id', $tag->id)->ordered();
    }

    public function user()
    {
        return $this->belongsTo(config('blogs.model.user'));
    }

    public function tag()
    {
        return $this->belongsTo(config('blogs.model.blog_tags'), 'blog_tag_id');
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
        return static::published()->get();
    }
}
