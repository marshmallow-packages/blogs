<?php

namespace Marshmallow\Blogs\Http\Controllers;

use App\Http\Controllers\Controller;
use Marshmallow\Breadcrumb\Facades\Breadcrumb;

class BlogController extends Controller
{
    public function __invoke($tag, $blog)
    {
        $blog = config('blogs.model.blog')::getByTranslatedSlug($blog);
        $tag = config('blogs.model.blog_tags')::getByTranslatedSlug($tag);
        $page = config('pages.model')::where('route_name', config('blogs.routes.blog'))->first();

        abort_unless($blog, 404);
        abort_unless($tag, 404);
        abort_unless($page, 404);

        $blog->useForSeo();

        Breadcrumb::add(__('Blog'), route('blogs'));
        Breadcrumb::add($blog->name, $blog->route());

        return view($page->getView())->with(
            array_merge($this->getBaseViewData($page), [
                'blog' => $blog,
                'layouts' => $page->flex('layout', [
                    'blog' => $blog,
                    'blog_count' => config('blogs.model.blog')::published()->count(),
                    'tags' => config('blogs.model.blog_tags')::query()->get(),
                    'latest' => config('blogs.model.blog')::published()->ordered()->where('id', '!=', $blog->id)->limit(2)->get()
                ]),
            ])
        );
    }
}
