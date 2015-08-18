<?php

namespace Luismarcelino\PostalPt;

use Illuminate\Support\ServiceProvider;

/**
 * CodigosPostaisServiceProvider
 *
 */

class CodigosPostaisServiceProvider extends ServiceProvider {

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
    * Bootstrap the application.
    *
    * @return void
    */
    public function boot()
    {
        // The publication files to publish
        $this->publishes([__DIR__ . '/../../config/config.php' => config_path('postal_pt.php')]);

        // Append the country settings
        $this->mergeConfigFrom(
            __DIR__ . '/../../config/config.php', 'postal_pt'
        );
    }

    /**
     * Register everything.
     *
     * @return void
     */
    public function register()
    {
        $this->registerPostCodes();
        $this->registerCommands();
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function registerPostCodes()
    {
        $this->app->bind('postal_pt', function($app)
        {
            return new CodigosPostais();
        });
    }

    /**
     * Register the artisan commands.
     *
     * @return void
     */
    protected function registerCommands()
    {
        $this->app['command.postal_pt.migration'] = $this->app->share(function($app)
        {
            return new MigrationCommand($app);
        });
        $this->app['command.postal_pt.seed'] = $this->app->share(function($app)
        {
            return new SeedPostCodesCommand($app);
        });

        $this->commands('command.postal_pt');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array('postal_pt');
    }
}
