<?php

namespace Nncodes\Meeting;

use Illuminate\Support\ServiceProvider;
use Nncodes\Meeting\Commands\MeetingCommand;

class MeetingServiceProvider extends ServiceProvider
{
    /**
     * Undocumented function
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {

            $this->publishes([
                __DIR__ . '/../config/meeting.php' => config_path('meeting.php'),
            ], 'config');

            $this->publishes([
                __DIR__ . '/../resources/views' => base_path('resources/views/vendor/meeting'),
            ], 'views');

            $migrationFileName = 'create_meetings_table.php';
            if (!$this->migrationFileExists($migrationFileName)) {
                $this->publishes([
                    __DIR__ . "/../database/migrations/{$migrationFileName}.stub" => database_path('migrations/' . date('Y_m_d_His', time()) . '_' . $migrationFileName),
                ], 'migrations');
            }

            $this->commands([
                MeetingCommand::class,
            ]);
        }
        
        //Set the default provider in the config file.
        $this->app->when([\Nncodes\Meeting\Meeting::class])
            ->needs(\Nncodes\Meeting\Contracts\Provider::class)
            ->give(\Nncodes\Meeting\Providers\Database\Provider::class);

        //TODO: set the provider in the config file.
        $this->app->bind('laravel-meeting:database', \Nncodes\Meeting\Providers\Database\Provider::class);

        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'meeting');
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/meeting.php', 'meeting');
    }

    /**
     * Undocumented function
     *
     * @param string $migrationFileName
     * @return boolean
     */
    public static function migrationFileExists(string $migrationFileName): bool
    {
        $len = strlen($migrationFileName);
        foreach (glob(database_path("migrations/*.php")) as $filename) {
            if ((substr($filename, -$len) === $migrationFileName)) {
                return true;
            }
        }

        return false;
    }
}
