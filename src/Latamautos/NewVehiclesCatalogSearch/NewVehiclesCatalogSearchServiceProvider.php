<?php namespace Latamautos\NewVehiclesCatalogSearch;

use Illuminate\Support\ServiceProvider;

class NewVehiclesCatalogSearchServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->package('latamautos/new-vehicles-catalog-search');
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app->bind('latam\core\persistence\contract\IDriveRepository', 'latam\core\persistence\object\DriveRepository');
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array();
	}

}
