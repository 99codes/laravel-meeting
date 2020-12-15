<?php

namespace Nncodes\Meeting\Commands;

use Illuminate\Console\Command;

class MeetingCommand extends Command
{
    public $signature = 'meeting';

    public $description = 'My command';

    public function handle()
    {
        $this->comment('All done');
    }
}
