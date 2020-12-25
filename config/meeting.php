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
        ],

    ],

    /**
     * @todo Zoom provider
     * 
     * Use the token generated from the JWT app and start making API 
     * requests to the Zoom APIs. 
     * 
     * @see https://marketplace.zoom.us/docs/guides/auth/jwt
     */
];
