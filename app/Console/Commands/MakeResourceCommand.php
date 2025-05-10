<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

class MakeResourceCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:resource {name : Entity name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create migration, model, controller, service, repository, and request for a entity';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = Str::studly($this->argument('name'));

        // 1. Create model and migration
        $this->call('make:model', [
            'name'        => "Models/{$name}",
            '--migration' => true,
        ]);

        // 2. Create controller with API resource
        $this->call('make:controller', [
            'name'  => "{$name}Controller",
            '--api' => true,
            '--model' => "App\\Models\\{$name}",
        ]);

        // 3. Interface
        $interfacePath = app_path("Repository/Interface/{$name}RepositoryInterface.php");
        if (!file_exists($interfacePath)) {
            $this->createInterface($name, $interfacePath);
            $this->info("Interface created: Repository/Interface/{$name}RepositoryInterface.php");
        }

        // 4. Repository
        $repoPath = app_path("Repository/Eloquent/{$name}Repository.php");
        if (!file_exists($repoPath)) {
            $this->createRepository($name, $repoPath);
            $this->info("Repository created: Repository/Eloquent/{$name}Repository.php");
        }

        // 5. Service
        $servicePath = app_path("Services/{$name}Service.php");
        if (!file_exists($servicePath)) {
            $this->createService($name, $servicePath);
            $this->info("Service created: Services/{$name}Service.php");
        }

        // 6. Create form request gruped
        $requestDir = app_path("Http/Requests/{$name}");
        if (!is_dir($requestDir)) {
            mkdir($requestDir, 0755, true);
        }
        foreach (['Store', 'Update'] as $prefix) {
            $requestName = "{$prefix}{$name}Request";
            $this->call('make:request', [
                'name' => "{$name}/{$requestName}",
            ]);
        }

        $this->info("Recurso '{$name}' generado exitosamente.");
    }

    protected function createInterface($name, $path)
    {
        $namespace = 'App\\Repository\\Interface';
        $content = <<<PHP
<?php

namespace {$namespace};

interface {$name}RepositoryInterface
{
    public function find(\$id);
    public function filter(array \$attributes, int \$paginate);
    public function store(array \$attributes);
    public function update(object \$model, array \$attributes);
    public function delete(object \$model);
}
PHP;

        file_put_contents($path, $content);
    }

    protected function createRepository($name, $path)
    {
        $modelClass = "App\\Models\\{$name}";
        $interfaceClass = "App\\Repository\\Interface\\{$name}RepositoryInterface";
        $namespace = 'App\\Repository\\Eloquent';

        $content = <<<PHP
<?php

namespace {$namespace};

use {$modelClass};
use App\Repository\BaseRepository;
use {$interfaceClass};

class {$name}Repository extends BaseRepository implements {$name}RepositoryInterface
{
    /**
     * Repository constructor.
     *
     * @param {$name} \$model
     */
    public function __construct({$name} \$model)
    {
        parent::__construct(\$model);
    }

    public function filter(array \$attributes, int \$paginate)
    {
        return \$this->model
            ->paginate(\$paginate);
    }

    public function update(object \$model, array \$attributes): {$name}
    {
        \$model->update(\$attributes);
        return \$model;
    }

    public function delete(object \$model): {$name}
    {
        \$model->delete();
        return \$model;
    }
}
PHP;

        file_put_contents($path, $content);
    }

    protected function createService($name, $path)
    {
        $modelClass = "App\\Models\\{$name}";
        $interfaceClass = "App\\Repository\\Interface\\{$name}RepositoryInterface";
        $namespace = 'App\\Services';
        $serviceVar = lcfirst($name);

        $content = <<<PHP
<?php

namespace {$namespace};

use {$modelClass};
use {$interfaceClass};
use Illuminate\Pagination\LengthAwarePaginator;

class {$name}Service
{
    public function __construct(
        protected {$name}RepositoryInterface \${$serviceVar}Repository
    ) {}

    /**
     * Use case: Obtener todos los registros según criterio de filtros y con paginación
     *
     * @param array \$attributes
     * @param int   \$paginate
     * @return LengthAwarePaginator<{$name}>
     */
    public function filterWithPaginate(array \$attributes, int \$paginate): LengthAwarePaginator
    {
        return \$this->{$serviceVar}Repository->filter(\$attributes, \$paginate);
    }

    /**
     * Use case: Obtener un registro según su identificador
     *
     * @param int \$id
     * @return ?{$name}
     */
    public function getById(int \$id): ?{$name}
    {
        return \$this->{$serviceVar}Repository->find(\$id);
    }

    /**
     * Use case: Crear un registro
     *
     * @param array \$attributes
     * @return {$name}
     */
    public function create(array \$attributes): {$name}
    {
        return \$this->{$serviceVar}Repository->store(\$attributes);
    }

    /**
     * Use case: Actualizar un registro
     *
     * @param {$name} \$model
     * @param array \$attributes
     * @return {$name}
     */
    public function update({$name} \$model, array \$attributes): {$name}
    {
        return \$this->{$serviceVar}Repository->update(\$model, \$attributes);
    }

    /**
     * Use case: Eliminar un registro
     *
     * @param {$name} \$model
     * @return {$name}
     */
    public function delete({$name} \$model): {$name}
    {
        return \$this->{$serviceVar}Repository->delete(\$model);
    }
}
PHP;

        file_put_contents($path, $content);
    }
}
