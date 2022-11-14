<?php

namespace Marshmallow\Blogs\Nova;

use App\Nova\Resource;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Text;
use Marshmallow\Seoable\Seoable;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Fields\BelongsTo;
use Marshmallow\Nova\TinyMCE\TinyMCE;
use Marshmallow\Nova\Flexible\Flexible;
use Laravel\Nova\Http\Requests\NovaRequest;
use Marshmallow\AdvancedImage\AdvancedImage;
use Marshmallow\Nova\Flexible\Nova\Traits\HasFlexable;
use Marshmallow\Translatable\Traits\TranslatableFields;

class Blog extends Resource
{
    use HasFlexable;
    use TranslatableFields;

    public static $group = 'Content';

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'Marshmallow\Blogs\Models\Blog';

    public static function label()
    {
        return __('Blog');
    }

    public static function singularLabel()
    {
        return __('Blogs');
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
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function translatableFields(NovaRequest $request)
    {
        return [
            BelongsTo::make(__('Tag'), 'tag', config('blogs.nova.blog_tags')),

            Text::make(__('Name'), 'name')
                ->sortable()
                ->required()
                ->rules(['required']),

            Textarea::make(__('Intro'), 'intro')
                ->sortable()
                ->required()
                ->rules(['required']),

            Flexible::make(__('Content'), 'content')
                ->addLayout(__('Text'), 'text', [
                    TinyMCE::make(__('Text'), 'text'),
                ])
                ->addLayout(__('Full size image'), 'image', [
                    $this->getAdvancedImageField(__('Full image'), 'image'),
                ])
                ->addLayout(__('Quote'), 'quote', [
                    Text::make(__('Quote'), 'quote'),
                    Text::make(__('Quote from'), 'quote_from'),
                ])
                ->button(__('Add more content'))
                ->fullWidth()
                ->collapsed()
                ->required()
                ->rules(['required']),

            $this->getAdvancedImageField(__('Overview image'), 'overview_image'),
            $this->getAdvancedImageField(__('Detail image'), 'detail_image'),

            DateTime::make(__('Publish date'), 'publish_date')
                ->required()
                ->rules(['required']),

            BelongsTo::make(__('Writer'), 'user', config('blogs.nova.user')),

            Seoable::make('SEO'),
        ];
    }

    protected function getAdvancedImageField($name, $column)
    {
        $sizes = config("blogs.images.{$column}");
        $name = "{$name} ({$sizes[0]}x{$sizes[1]})";
        return AdvancedImage::make($name, $column)
            ->croppable($sizes[0] / $sizes[1])
            ->resize($sizes[0], $sizes[1])
            ->hideFromIndex()
            ->required();
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function cards(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function filters(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function lenses(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function actions(NovaRequest $request)
    {
        return [];
    }
}
