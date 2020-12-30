<?php

namespace Nncodes\Meeting\Providers\Zoom\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Nncodes\Meeting\Models\MeetingRoom;
use Nncodes\Meeting\Providers\Zoom\Sdk\Zoom;

class SyncUsersCommand extends Command
{
    /**
     * Command signature
     *
     * @var string
     */
    public $signature = 'meeting:zoom-sync-users {--group=}';

    /**
     * Command description
     *
     * @var string
     */
    public $description = 'Sync zoom users';

    /**
     * Command handler
     *
     * @return void
     */
    public function handle(Zoom $api)
    {
        try {
            if (! $zoomGroupId = $this->option('group')) {
                $zoomGroupId = config('meeting.providers.zoom.group_id');
            }
            
            $users = $api->groupMembers($zoomGroupId);

            $deletableUsers = MeetingRoom::whereNotIn('uuid', $users->pluck('id')->values())->get();

            $updates = collect();

            $deletableUsers->each(function ($user) use ($updates) {
                $user->status = 'deleted';
                $user->delete();

                $updates->push($user);
            });

            foreach ($users->all() as $user) {
                $room = MeetingRoom::updateOrCreate(
                    ['uuid' => $user->id],
                    [
                        'name' => $user->firstName . ' ' . $user->lastName,
                        'email' => $user->email,
                        'type' => $user->type,
                        'group' => $zoomGroupId,
                    ]
                );

                $room->status = $room->wasRecentlyCreated ? 'created' : 'updated';
                $updates->push($room);
            }
            
            $this->log($updates, 'created');
            $this->log($updates, 'updated');
            $this->log($updates, 'deleted');
        } catch (\Throwable $th) {
            $this->error($th->getMessage());
        }
    }

    /**
     * Undocumented function
     *
     * @param \Illuminate\Support\Collection $updates
     * @param string $type
     * @return void
     */
    protected function log(Collection $updates, string $type): void
    {
        $messagePattern = '%d %s %s';
        $tableKeys = ['id', 'uuid', 'name', 'email', 'type', 'status'];

        $headers = array_keys(
            Arr::only($updates->first()->toArray(), $tableKeys)
        );

        $items = $updates->where('status', $type);

        if ($items->count()) {
            $this->info(sprintf(
                $messagePattern,
                $items->count(),
                Str::plural('user', $items->count()),
                $type
            ));
            
            $this->table(
                $headers,
                $items->map(fn ($user) => $user->only($tableKeys))->toArray()
            );
        }
    }
}
