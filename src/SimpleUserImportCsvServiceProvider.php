<?php

namespace VoyagerInc\SimpleUserImportCsv;

class SimpleUserImportCsvServiceProvider extends \Illuminate\Support\ServiceProvider
{
    public function register()
    {
        $this->app->bind(Services\Interfaces\CsvFileReaderInterface::class, function () {
            return new Services\CsvFileReader();
        });

        $this->app->bind(Services\Interfaces\UserImportServiceInterface::class, function () {
            return new Services\UserImportService();
        });
    }

    public function boot()
    {
        if (!$this->app->runningInConsole()) {
            return;
        }

        $this->commands([
            Console\InstallCommand::class,
        ]);

        $this->publishes([
            __DIR__ . '/../config/simple_import_user.php'   =>  config_path('simple_import_user.php'),
        ], 'simple-upload-file');
    }


    public function provides()
    {
        return [
            Console\InstallCommand::class,
            Services\Interfaces\CsvFileReaderInterface::class,
            Services\Interfaces\UserImportServiceInterface::class,
        ];
    }
}
