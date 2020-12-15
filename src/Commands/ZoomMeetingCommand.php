<?php

namespace Nncodes\ZoomMeeting\Commands;

use Illuminate\Console\Command;

class ZoomMeetingCommand extends Command
{
    public $signature = 'laravel-zoom-meeting';

    public $description = 'My command';

    public function handle()
    {
        $this->comment('All done');
    }
}
