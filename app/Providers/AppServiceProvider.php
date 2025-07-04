<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Set default string length for MySQL
        Schema::defaultStringLength(191);
        
        // Disable foreign key constraints during migrations
        Schema::disableForeignKeyConstraints();
        
        // Disable default Laravel migrations in local environment
        if (app()->environment('local')) {
            $this->disableDefaultMigrations();
        }
    }

    /**
     * Disable default Laravel migrations by renaming the files
     */
    protected function disableDefaultMigrations(): void
    {
        $defaultMigrations = [
            '2014_10_12_000000_create_users_table.php',
            '2014_10_12_100000_create_password_reset_tokens_table.php',
            '2019_08_19_000000_create_failed_jobs_table.php',
            '2019_12_14_000001_create_personal_access_tokens_table.php'
        ];

        foreach ($defaultMigrations as $migration) {
            $originalPath = database_path('migrations/'.$migration);
            $disabledPath = database_path('migrations/'.$migration.'.disabled');
            
            if (file_exists($originalPath) && !file_exists($disabledPath)) {
                rename($originalPath, $disabledPath);
            }
        }
    }
}