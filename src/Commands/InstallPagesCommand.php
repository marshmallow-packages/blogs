<?php

namespace Marshmallow\Blogs\Commands;

use Illuminate\Console\Command;
use Marshmallow\Seoable\Models\Route;
use Illuminate\Support\Facades\Artisan;

class InstallPagesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'blogs:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install the Marshmallow Blog packages';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->artisanCall(
            'vendor:publish --provider="Marshmallow\Blogs\BlogsServiceProvider"',
            'Blogs config is published.'
        );

        $this->artisanCall(
            'migrate',
            'Database has been migrated.'
        );

        $this->artisanCall(
            'marshmallow:resource Blog Blogs --quiet',
            'Blog Nova resource has been created.'
        );

        $this->artisanCall(
            'marshmallow:resource BlogTag Blogs --quiet',
            'Blog Nova resource has been created.'
        );

        $this->createNewRoute(
            path: 'blog/{blogTag:slug}/{blog:slug}',
            method: 'get',
            controller: 'Marshmallow\Blogs\Http\Controllers\BlogController',
            name: 'blog-detail',
        );

        $this->createNewRoute(
            path: 'blog/{blogTag:slug}',
            method: 'get',
            controller: 'Marshmallow\Blogs\Http\Controllers\BlogTagController',
            name: 'blog-tag',
        );
    }

    protected function createNewRoute(string $path, string $method, string $controller, string $name)
    {
        if (Route::where('path', $path)->orWhere('name', $name)->first()) {
            return;
        }

        $route = new Route;
        $route->path = $path;
        $route->method = $method;
        $route->controller = $controller;
        $route->name = $name;
        $route->save();
    }

    protected function artisanCall($command, $info = null)
    {
        Artisan::call($command);

        if ($info) {
            $this->info($info);
        }
    }
}
