<?php

return [
   
    /**
     * Default Meeting Provider
     * 
     * Here you can specify which meeting provider the package should use by 
     * default. Of course you may use many providers at once using the package.
     */
    'default' => env('MEETING_PROVIDER', 'zoom'),

    /**
     * Meeting Providers
     * 
     * Here are each of the meetings provider setup for the package.
     */

    'providers' => [
        'zoom' => [
            'type' => \Nncodes\Meeting\Providers\Zoom\ZoomProvider::class,
            'jwt_token' => env('ZOOM_TOKEN'),
            'group_id' => env('ZOOM_GROUP'),
            'share_rooms' => true,
            'meeting_settings' => [
                "host_video" => false,
                "participant_video" => false,
                "join_before_host" => false,
                "jbh_time" => 0,
                "mute_upon_entry" => true,
                "approval_type" => 0,
                "registration_type" => 1,
                "close_registration" => true,
                "waiting_room" => true,
                "registrants_confirmation_email" => false,
                "registrants_email_notification" => false,
                "meeting_authentication" => false
            ]
        ]
    ],

    /**
     * Allow concurrent Meetings
     */
    'allow_concurrent_meetings' => [
        'host' => false,
        'participant' => false,
        'presenter' => false,
        'scheduler' => true,
    ]

];
