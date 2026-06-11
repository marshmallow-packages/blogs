![alt text](https://marshmallow.dev/cdn/media/logo-red-237x46.png "marshmallow.")

# Laravel Nova Blogs

[![Latest Version on Packagist](https://img.shields.io/packagist/v/marshmallow/blogs)](https://packagist.org/packages/marshmallow/blogs)
[![Total Downloads](https://img.shields.io/packagist/dt/marshmallow/blogs)](https://packagist.org/packages/marshmallow/blogs)
[![Issues](https://img.shields.io/github/issues/marshmallow-packages/blogs)](https://github.com/marshmallow-packages/blogs/issues)
[![Licence](https://img.shields.io/github/license/marshmallow-packages/blogs)](https://github.com/marshmallow-packages/blogs)
![PHP Syntax Checker](https://github.com/marshmallow-packages/blogs/actions/workflows/php-syntax-checker.yml/badge.svg?branch=main)

This packages add the resources you need to create a simple blog in Nova. This is fully extendable.

## Requirements

-   PHP `^8.3`
-   [Laravel Nova](https://nova.laravel.com) `^5.0`

## Installation

### Composer

You can install the package via composer:

```bash
composer require marshmallow/blogs
```

### Run the install command

The package ships an install command that publishes the config file, runs the
migrations (creating the `blogs` and `blog_tags` tables), generates the `Blog`
and `BlogTag` Nova resources, and registers the blog detail and tag routes:

```bash
php artisan blogs:install
```

### Make sure the routes work

Create a page in your Nova Pages Resource. This page should have the route name `blog-detail-page`.
Create a page in your Nova Pages Resource. This page should have the route name `blog-tag-page`.

## Configuration

The config file is published to `config/blogs.php`. Every value can be
overridden to swap in your own models, Nova resources and route names.

| Key | Default | Description |
| --- | --- | --- |
| `publish_date_format` | `d M` | Date format used by `Blog::dateFormatted()`. |
| `model.blog` | `Marshmallow\Blogs\Models\Blog` | Blog Eloquent model. |
| `model.blog_tags` | `Marshmallow\Blogs\Models\BlogTag` | Blog tag Eloquent model. |
| `model.user` | `App\Models\User` | User model a blog belongs to. |
| `nova.blog_tags` | `Marshmallow\Blogs\Nova\BlogTag` | Nova resource for blog tags. |
| `nova.user` | `App\Nova\User` | Nova resource for the related user. |
| `images.image` | `[1920, 800]` | Dimensions for the main image. |
| `images.overview_image` | `[500, 280]` | Dimensions for the overview image. |
| `images.detail_image` | `[900, 450]` | Dimensions for the detail image. |
| `routes.blog` | `blog-detail` | Route name resolved by `Blog::route()`. |
| `routes.blog_tags` | `blog-tag` | Route name for a tag overview. |
| `page_route_names.blog` | `blog-detail-page` | Nova page route name for blog details. |
| `page_route_names.blog_tags` | `blog-tag-page` | Nova page route name for tag pages. |

## Usage

Blogs are managed through the generated Nova resources. On the frontend you work
with the `Marshmallow\Blogs\Models\Blog` model, which exposes a number of query
scopes and helper methods:

```php
use Marshmallow\Blogs\Models\Blog;

// Published blogs, newest first.
$blogs = Blog::published()->ordered()->get();

// Apply the ?q= search filter from the current request.
$results = Blog::published()->filtered()->ordered()->get();

// Blogs for a single tag.
$tagged = Blog::tagged($tag)->get();

foreach ($blogs as $blog) {
    $blog->route();          // URL to the blog detail page
    $blog->dateFormatted();  // publish_date in config('blogs.publish_date_format')
    $blog->getImage();       // asset URL, defaults to the overview_image column
    $blog->tag;              // related BlogTag
    $blog->user;             // related user
}
```

The `Blog` model also implements Marshmallow's `Seoable` and sitemap traits, so
published blogs are automatically included in the generated sitemap.

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Security

If you discover any security related issues, please email stef@marshmallow.dev instead of using the issue tracker.

## Credits

-   [Stef](https://marshmallow.dev)
-   [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
