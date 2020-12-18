<?php

namespace Nncodes\Meeting\Commands;

use Illuminate\Console\Command;

class MeetingCommand extends Command
{
    /**
     * Command signature
     *
     * @var string
     */
    public $signature = 'meeting';

    /**
     * Command description
     *
     * @var string
     */
    public $description = 'My command';

    /**
     * Command handler
     *
     * @return void
     */
    public function handle()
    {
        $this->comment('All done');
    }
}
