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
        $this->publishes([
            __DIR__ . '/../config/simple_user_import_csv.php'   =>  config_path('simple_user_import_csv.php'),
        ], 'simple-user-import-csv');

        if (!$this->app->runningInConsole()) {
            return;
        }

        $this->commands([
            Console\InstallCommand::class,
        ]);
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
