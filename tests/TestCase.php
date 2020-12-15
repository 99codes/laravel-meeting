<?php

namespace Nncodes\ZoomMeeting\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use Nncodes\ZoomMeeting\ZoomMeetingServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    public function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'Nncodes\\ZoomMeeting\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );
    }

    protected function getPackageProviders($app)
    {
        return [
            ZoomMeetingServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.default', 'sqlite');
        $app['config']->set('database.connections.sqlite', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);

        /*
        include_once __DIR__.'/../database/migrations/create_laravel_zoom_meeting_table.php.stub';
        (new \CreatePackageTable())->up();
        */
    }
}
