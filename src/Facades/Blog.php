<?php

namespace Marshmallow\Blogs\Facades;

class Blog extends \Illuminate\Support\Facades\Facade
{
    protected static function getFacadeAccessor()
    {
        return \Marshmallow\Blogs\Blog::class;
    }
}
