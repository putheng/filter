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
Filter class located `app/Filters`

Create a new Filter Extension class
`php artisan filter:by DifficultyFilter`
Filter Extension class located `app/Filters/Filter`

Add `DifficultyFilter` extension to `DifficultyFilter` class on `$filters` property
```php
use App\Filters\Filter\DifficultyFilter;

protected $filters = [
    'difficulty' => DifficultyFilter::class,
];
```

Setup `DifficultyFilter` filter class
```php
namespace App\Filters\Filter;

use Putheng\Filter\FilterAbstract;
use Illuminate\Database\Eloquent\Builder;

class DifficultyFilter extends FilterAbstract
{
    /**
     * Mappings for database values.
     * 
     * Map b on query string map to beginner column on database
     * 
     * 'b' => 'beginner'
     * 'beginner' => 'beginner'
     * 
     * @return array
     */
    public function mappings()
    {
        return [
            'b' => 'beginner',
            'intermediate' => 'intermediate',
            'advanced' => 'advanced',
        ];
    }

    /**
     * Filter by course difficulty.
     *
     * @param  string $access
     * @return Illuminate\Database\Eloquent\Builder
     */
    public function filter(Builder $builder, $value)
    {
        $value = $this->resolveFilterValue($value);

        if ($value === null) {
            return $builder;
        }

        return $builder->where('difficulty', $value);
    }
}
```

##### Simple filter
Add filter scope to model we want to filter, example `Course` model
```php
namespace App;
// use filter class we just generated
use App\Filters\CourseFilters;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Course extends Model
{
    public function scopeFilter(Builder $builder, Request $request, array $filters = [])
    {
        return (new CourseFilters($request))->add($filters)->filter($builder);
    }
}

```

##### Filter base on relationship,
Example: `Course` and `Subject` model,
add polymorphic relationship
```php
public function subjects()
{
    return $this->morphToMany(Subject::class, 'subjectable');
}
```

Builder
```php
return $builder->whereHas('subjects', function (Builder $builder) use ($value) {
    $builder->where('slug', $value);
});
```



## Usage

On controller use `Course` model add `filter` method and pass `$request` argument
```php
namespace App\Http\Controllers;

use App\Course;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index(Request $request)
    {
        $filter = Course::filter($request)->get();
    }
}

```