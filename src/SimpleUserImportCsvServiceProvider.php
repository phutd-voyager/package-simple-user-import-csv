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
    }
}
