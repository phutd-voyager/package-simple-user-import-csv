<?php

namespace VoyagerInc\SimpleUserImportCsv\Console;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class InstallCommand extends Command
{
    protected $signature = 'simple-user-import-csv:install';

    protected $description = 'Install the Simple User Import CSV package';

    public function handle()
    {
        return $this->install();
    }

    protected function install()
    {
        $this->info('Installing Simple User Import CSV package...');

        // Controllers
        (new Filesystem)->ensureDirectoryExists(app_path('Http/Controllers'));
        (new Filesystem)->copyDirectory(__DIR__.'/../../stubs/app/Controllers', app_path('Http/Controllers'));

        // Requests
        (new Filesystem)->ensureDirectoryExists(app_path('Http/Requests'));
        (new Filesystem)->copyDirectory(__DIR__.'/../../stubs/app/Requests', app_path('Http/Requests'));

        // Views
        (new Filesystem)->ensureDirectoryExists(resource_path('views'));
        (new Filesystem)->copyDirectory(__DIR__.'/../../stubs/resources/views', resource_path('views'));

        // Files
        (new Filesystem)->ensureDirectoryExists(public_path('app/temp'));
        (new Filesystem)->copyDirectory(__DIR__.'/../../stubs/public/app/temp', public_path('app/temp'));

        // Routes
        copy(__DIR__.'/../../stubs/routes/simple_user_import_csv.php', base_path('routes/simple_user_import_csv.php'));

        $this->line('');
        $this->components->info('Package scaffolding installed successfully.');
    }
}