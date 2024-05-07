<?php

namespace VoyagerInc\SimnpleUserImportCsv;

class SimpleUserImportCsvServiceProvider extends \Illuminate\Support\ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        if (!$this->app->runningInConsole()) {
            return;
        }

        $this->commands([
            \VoyagerInc\SimpleUserImportCsv\Console\InstallHandlerCommand::class,
        ]);
    }

     /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [\VoyagerInc\SimpleUserImportCsv\Console\InstallHandlerCommand::class];
    }
}
