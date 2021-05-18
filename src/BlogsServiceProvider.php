<?php

namespace Marshmallow\Blogs;

use Illuminate\Support\ServiceProvider;
use Marshmallow\Blogs\Commands\InstallPagesCommand;

class BlogsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
        $this->mergeConfigFrom(
            __DIR__ . '/../config/blogs.php',
            'blogs'
        );

        $this->commands([
            InstallPagesCommand::class,
        ]);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        /*
         * Views
         */
        $this->loadViewsFrom(__DIR__ . '/../views', 'marshmallow');

        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        // $this->publishes([
        //     __DIR__ . '/../views' => resource_path('views/vendor/marshmallow'),
        // ]);

        $this->publishes([
            __DIR__ . '/../config/blogs.php' => config_path('blogs.php'),
        ]);
    }
}
