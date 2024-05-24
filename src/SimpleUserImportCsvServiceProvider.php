<?php

namespace VoyagerInc\SimpleUserImportCsv;

class SimpleUserImportCsvServiceProvider extends \Illuminate\Support\ServiceProvider
{
    public function register()
    {
        $this->registerCsvFileReader();
        $this->registerUserValidator();
        $this->registerUserImportService();
        $this->registerCsvWritter();
    }

    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/user_import_csv.php'   =>  config_path('user_import_csv.php'),
        ], 'user-import-csv');

        if (!$this->app->runningInConsole()) {
            return;
        }

        $this->commands([
            Console\InstallCommand::class,
        ]);
    }

    protected function registerCsvFileReader()
    {
        $this->app->bind(Services\Interfaces\CsvFileReaderInterface::class, function ($app) {
            return new Services\CsvFileReader();
        });
    }

    protected function registerUserValidator()
    {
        $this->app->bind(Services\Interfaces\UserValidatorInterface::class, function ($app) {
            return new Services\UserValidator();
        });
    }

    protected function registerUserImportService()
    {
        $this->app->bind(Services\Interfaces\UserImportServiceInterface::class, function ($app) {
            $validator = $app->make(Services\Interfaces\UserValidatorInterface::class);

            return new Services\UserImportService($validator);
        });
    }

    protected function registerCsvWritter()
    {
        $this->app->bind(Services\Interfaces\CsvWritterInterface::class, function ($app) {
            return new Services\CsvWritter();
        });
    }
}
