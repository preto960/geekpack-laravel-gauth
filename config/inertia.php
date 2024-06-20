<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Root View
    |--------------------------------------------------------------------------
    |
    | This is the view that will be returned by the root controller route.
    | Typically, this is your main application layout or template.
    |
    */

    'root_view' => 'layouts.app',

    /*
    |--------------------------------------------------------------------------
    | Version
    |--------------------------------------------------------------------------
    |
    | Inertia uses this option to determine the current version of your application.
    | This can be any string that uniquely identifies the version of your app.
    |
    */

    'version' => function () {
        return md5_file(public_path('mix-manifest.json'));
    },

    /*
    |--------------------------------------------------------------------------
    | Share Data
    |--------------------------------------------------------------------------
    |
    | These key / value pairs will automatically be included in the Inertia.js
    | page data for every page. You may override this array as needed.
    |
    */

    'share' => [
        // Share any global data here, for example current user data
        'auth' => function () {
            return auth()->user() ? [
                'user' => auth()->user()->only('id', 'name', 'email'),
            ] : null;
        },
    ],

];
