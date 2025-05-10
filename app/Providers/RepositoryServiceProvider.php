<?php

namespace App\Providers;

use Illuminate\Support\Facades\File;
use App\Repository\BaseRepository;
use App\Repository\EloquentRepositoryInterface;
use Illuminate\Support\ServiceProvider;

/**
 * Class RepositoryServiceProvider
 * @package App\Providers
 */
class RepositoryServiceProvider extends ServiceProvider
{
	/**
	 * Register services.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app->bind(EloquentRepositoryInterface::class, BaseRepository::class);

		$repositoryFolder = app_path('Repository/Interface');
		$files = File::files($repositoryFolder);

		$interfaceNamespace = 'App\Repository\Interface';
		$repositoryNamespace = 'App\Repository\Eloquent';

		foreach ($files as $file) {
			$fileName = pathinfo($file, PATHINFO_FILENAME);
			
			if ($fileName !== 'EloquentRepositoryInterface') {
				$interfaceClass = $interfaceNamespace . '\\' . $fileName;
				$repositoryClass = $repositoryNamespace . '\\' . str_replace('Interface', '', $fileName);
				$this->app->bind($interfaceClass, $repositoryClass);
			}
		}
	}

	/**
	 * Bootstrap services.
	 *
	 * @return void
	 */
	public function boot()
	{
		//
	}
}
