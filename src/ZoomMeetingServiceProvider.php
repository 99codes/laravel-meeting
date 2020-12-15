<?php

namespace Nncodes\ZoomMeeting;

use Illuminate\Support\ServiceProvider;
use Nncodes\ZoomMeeting\Commands\ZoomMeetingCommand;

class ZoomMeetingServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/laravel-zoom-meeting.php' => config_path('laravel-zoom-meeting.php'),
            ], 'config');

            $this->publishes([
                __DIR__ . '/../resources/views' => base_path('resources/views/vendor/laravel-zoom-meeting'),
            ], 'views');

            $migrationFileName = 'create_laravel_zoom_meeting_table.php';
            if (! $this->migrationFileExists($migrationFileName)) {
                $this->publishes([
                    __DIR__ . "/../database/migrations/{$migrationFileName}.stub" => database_path('migrations/' . date('Y_m_d_His', time()) . '_' . $migrationFileName),
                ], 'migrations');
            }

            $this->commands([
                ZoomMeetingCommand::class,
            ]);
        }

        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'laravel-zoom-meeting');
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/laravel-zoom-meeting.php', 'laravel-zoom-meeting');
    }

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
