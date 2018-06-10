<?php

namespace Backpack\Generators\Console\Commands;

use Illuminate\Console\GeneratorCommand;

class CustomFormBackpackCommand extends GeneratorCommand
{
        /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'backpack:custom-form';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'backpack:custom-form {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Custom form layout example: admin/person/custom-form';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'View';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__.'/../stubs/custom-form.stub';
    }

    /**
     * Alias for the fire method.
     *
     * In Laravel 5.5 the fire() method has been renamed to handle().
     * This alias provides support for both Laravel 5.4 and 5.5.
     */
    public function handle()
    {
        $this->fire();
    }

    /**
     * Execute the console command.
     *
     * @return bool|null
     */
    public function fire()
    {
        $name = $this->getNameInput();

        $path = $this->getPath($name);

        if ($this->alreadyExists($this->getNameInput())) {
            $this->error($this->type.' already exists!');

            return false;
        }

        $this->makeDirectory($path);

        $this->files->put($path, $this->buildClass($name));

        $name=str_replace(".blade.php","",basename($path));

        $this->info($this->type.' created successfully.');

        $this->info('');
        $this->info('In your CRUD controller add:');
        $this->info("\$this->crud->setFormView('".$name."'');");

        $this->info('');
        $this->info('to use the entire width:');
        $this->info("\$this->crud->setFormView('".$name."'',true);");
    }

    /**
     * Determine if the class already exists.
     *
     * @param string $name
     *
     * @return bool
     */
    protected function alreadyExists($name)
    {
        return $this->files->exists($this->getPath($name));
    }

    /**
     * Get the destination class path.
     *
     * @param string $name
     *
     * @return string
     */
    protected function getPath($name)
    {
        return $this->laravel['path'].'/../resources/views/'.str_replace('\\', '/', $name).'.blade.php';
    }

    /**
     * Build the class with the given name.
     *
     * @param string $name
     *
     * @return string
     */
    protected function buildClass($name)
    {
        return $this->files->get($this->getStub());
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [

        ];
    }


}
