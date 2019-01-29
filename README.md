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

##### Create a filter

`php artisan filter:make CourseFilter`

