<?php

namespace Putheng\Filter\Commands;

use Illuminate\Console\Command;
use Putheng\Filter\Traits\Generatable;

class FiltersMakeCommand extends Command
{
    use Generatable;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'filter:make {filter}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new filter class';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $controllerBase = app_path() . '/';
        $path = $controllerBase;
        $namespace = 'App';
        
        $arg = 'Filters\\'. $this->argument('filter');

        $fileParts = explode('\\', $arg);
        $fileName = array_pop($fileParts);

        $cleanPath = implode('/', $fileParts);

        if (count($fileParts) >= 0) {
            $path = $path . $cleanPath;

            $namespace = $namespace . '\\' . str_replace('/', '\\', $cleanPath);

            if (!is_dir($path)) {
                mkdir($path, 0777, true);
            }
        }
        
        $target = $path . '/' . $fileName . '.php';

        if (file_exists($target)) {
            return $this->error('Filter already exists!');
        }

        $stub = $this->generateStub('filters', [
            'DummyClass' => $fileName,
            'DummyNamespace' => $namespace,
        ]);

        file_put_contents($target, $stub);
    }
}
