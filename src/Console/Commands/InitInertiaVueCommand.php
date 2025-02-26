<?php

namespace Hexters\Laramodule\Console\Commands;

use Illuminate\Support\Str;
use Illuminate\Console\Command;

class InitInertiaVueCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'inertia:init-vue
    { --module= : Module name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Init InertiaJs components vue';

    public function getRouteStub()
    {

        $stub = public_path('/stub/inertia.route.stub');
        if (!file_exists($stub)) {
            $stub = __DIR__ . '/stubs/inertia.route.stub';
        }

        return $stub;
    }

    public function getWelcomeStub()
    {

        $stub = public_path('/stub/inertia.welcome.vue.stub');
        if (!file_exists($stub)) {
            $stub = __DIR__ . '/stubs/inertia.welcome.vue.stub';
        }

        return $stub;
    }

    protected function moduleName()
    {
        return Str::of($this->option('module'));
    }

    protected function buildClass($name)
    {

        $name = file_get_contents($name);

        $module =  $this->moduleName();
        $name = str_replace([
            '{{ module }}',
            '{{module}}',
            '{{ moduleLower }}',
            '{{moduleLower}}',
        ], [
            $module->studly(),
            $module->studly(),
            $module->lower(),
            $module->lower(),
        ], $name);

        return $name;
    }

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $module =  $this->moduleName();


        $route = $this->buildClass(
            $this->getRouteStub()
        );
        $path = module_path($module, 'routes');
        file_put_contents("{$path}/web.php", $route);
        $this->components->info('Inertia route has been created');


        $welcome = $this->buildClass(
            $this->getWelcomeStub()
        );
        $path = module_path($module, 'Resources/pages');
        if (!is_dir($path)) {
            @mkdir($path);
        }
        file_put_contents("{$path}/Welcome.vue", $welcome);
        $this->components->info('Inertia template has been created');
    }
}
