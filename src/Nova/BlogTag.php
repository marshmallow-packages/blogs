<?php

namespace Marshmallow\Blogs\Nova;

use App\Nova\Resource;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Text;
use Marshmallow\Seoable\Seoable;
use Marshmallow\Nova\Flexible\Nova\Traits\HasFlexable;
use Marshmallow\Translatable\Traits\TranslatableFields;

class BlogTag extends Resource
{
    use HasFlexable;
    use TranslatableFields;

    public static $group = 'Content';

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'Marshmallow\Blogs\Models\BlogTag';

    public static function label()
    {
        return __('Blog tag');
    }

    public static function singularLabel()
    {
        return __('Blog tags');
    }

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'name',
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function translatableFields(Request $request)
    {
        return [
            Text::make('Name')->sortable(),
            Seoable::make('Seo'),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function cards(Request $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function lenses(Request $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function actions(Request $request)
    {
        return [];
    }
}
