<?php

namespace Marshmallow\Blogs\Http\Controllers;

use App\Http\Controllers\Controller;
use Marshmallow\Breadcrumb\Facades\Breadcrumb;

class BlogTagController extends Controller
{
    public function __invoke($tag)
    {
        $tag = config('blogs.model.blog_tags')::getByTranslatedSlug($tag);
        $page = config('pages.model')::where('route_name', config('blogs.page.blog_tags'))->first();

        abort_unless($tag, 404);
        abort_unless($page, 404);

        $tag->useForSeo();

        Breadcrumb::add(__('Blog'), route('blogs'));
        Breadcrumb::add($tag->name, $tag->route());

        return view($page->getView())->with(
            array_merge($this->getBaseViewData($page), [
                'layouts' => $page->flex('layout', [
                    //
                ]),
            ])
        );
    }
}
