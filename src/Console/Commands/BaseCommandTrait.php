<?php

namespace Hexters\Laramodule\Console\Commands;

use Illuminate\Support\Str;

trait BaseCommandTrait
{

    /**
     * Get the root namespace for the class.
     *
     * @return string
     */
    protected function rootNamespace()
    {
        $module = $this->getModuleNameInput();

        if (!is_dir(module_path($module))) {
            $this->error('Module not found!');
            exit();
        }

        $namespace = "Modules\\" . $module . '\\';

        return $namespace;
    }

    /**
     * Get the destination class path.
     *
     * @param  string  $name
     * @return string
     */
    protected function getPath($name)
    {
        $name = Str::replaceFirst($this->rootNamespace(), '', $name);
        $module = $this->getModuleNameInput();
        $path = base_path('modules') . '/' . $module . '/' . str_replace('\\', '/', $name) . '.php';
        return $path;
    }

    /**
     * Get module name
     *
     * @return void
     */
    protected function getModuleNameInput()
    {
        return ltrim(rtrim($this->option('module'), '/'), '/');
    }

    /**
     * Overite namespace module
     *
     * @param [type] $path
     * @return void
     */
    protected function overiteNamespace($path)
    {
        return 'Modules\\' . $this->getModuleNameInput() . $path;
    }
}