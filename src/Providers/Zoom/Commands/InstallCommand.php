<?php

namespace Nncodes\Meeting\Providers\Zoom\Commands;

use Illuminate\Console\Command;

class InstallCommand extends Command
{
    /**
     * Command signature
     *
     * @var string
     */
    public $signature = 'meeting:install {--config : Whether the config should be published}';

    /**
     * Command description
     *
     * @var string
     */
    public $description = 'Publishes the migration files and the config called with --config';

    /**
     * Command handler
     *
     * @return void
     */
    public function handle()
    {
        $this->call('vendor:publish', [
            '--provider' => 'Nncodes\Meeting\MeetingServiceProvider',
            '--tag' => 'migrations',
        ]);

        $this->call('vendor:publish', [
            '--provider' => 'Nncodes\MetaAttributes\MetaAttributesServiceProvider',
            '--tag' => 'migrations',
        ]);

        if ($this->option('config')) {
            $this->call('vendor:publish', [
                '--provider' => 'Nncodes\Meeting\MeetingServiceProvider',
                '--tag' => 'config',
            ]);
        }
    }
}
