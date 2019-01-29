<?php

namespace Putheng\Filter\Commands;

use Illuminate\Console\Command;
use Putheng\Filter\Traits\Generatable;

class FilterChildCommand extends Command
{
    use Generatable;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'filter:by {filter}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new Filter Extension class';

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
        $arg = $this->argument('filter');

        $namespace = 'App';
        
        $arg = 'Filters\\Filter\\'. $arg;

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

        $stub = $this->generateStub('filter', [
            'DummyClass' => $fileName,
            'DummyNamespace' => $namespace,
        ]);

        file_put_contents($target, $stub);
    }
}
