Installation
------------

Require this package with composer. It is recommended to only require the package for development.
```
composer require putheng/filter
```

Laravel 5.5 uses Package Auto-Discovery, so doesn't require you to manually add the ServiceProvider.

### Setting up from scratch

#### Laravel 5.5+:
If you don't use auto-discovery, add the ServiceProvider to the providers array in `config/app.php`
```php
Putheng\Filter\FilterServiceProvider::class,
```

##### Create a new Filter class

Example:
`php artisan filter:make CourseFilter`
Filter class is locat `app/Filters`

Create a new Filter Extension class
`php artisan filter:by DifficultyFilter`
Filter Extension class is locat `app/Filters/Filter`

Add `DifficultyFilter` extension to `DifficultyFilter` class on `$filters` property
```php
use App\Filters\Filter\DifficultyFilter;

protected $filters = [
    'difficulty' => DifficultyFilter::class,
];
```

Add filter scope to model we want to filter, example `Course` model
```php
//User filter class that we just generated
use App\Filters\CourseFilters;

//User Eloquent's builder class
use Illuminate\Database\Eloquent\Builder;

public function scopeFilter(Builder $builder, Request $request, array $filters = [])
{
    return (new CourseFilters($request))->add($filters)->filter($builder);
}
```