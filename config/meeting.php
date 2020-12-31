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
   
            /**
            * Provider class
            **/
           'type' => \Nncodes\Meeting\Providers\Zoom\ZoomProvider::class,
   
           /**
            * JWT Zoom Token 
            * @see https://marketplace.zoom.us/docs/guides/auth/jwt
            **/
           'jwt_token' => env('ZOOM_TOKEN'),
   
           /**
            * Zoom Group ID
            * 
            * @see https://marketplace.zoom.us/docs/api-reference/zoom-api/groups/group
            **/
           'group_id' => env('ZOOM_GROUP'),
   
            /**
            * Share Rooms
            * 
            * Delegate to the package the responsability of handling the allocations of rooms.
            **/
           'share_rooms' => true,
   
            /**
            * Meeting resource seetings
            * 
            * @see https://marketplace.zoom.us/docs/api-reference/zoom-api/meetings/meeting
            **/
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
