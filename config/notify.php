<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Notify Theme
    |--------------------------------------------------------------------------
    |
    | You can change the theme of notifications by specifying the desired theme.
    | By default the theme light is activated, but you can change it by
    | specifying the dark mode. To change theme, update the global variable to `dark`
    |
    */

    'theme' => env('NOTIFY_THEME', 'light'),

    /*
    |--------------------------------------------------------------------------
    | Notification timeout
    |--------------------------------------------------------------------------
    |
    | Defines the number of seconds during which the notification will be visible.
    |
    */

    'timeout' => 5000,

    /*
    |--------------------------------------------------------------------------
    | Preset Messages
    |--------------------------------------------------------------------------
    |
    | Define any preset messages here that can be reused.
    | Available model: connect, drake, emotify, smiley, toast
    |
    */

    'preset-messages' => [
        'user-created' => [
            'message' => 'User has been created successfully.',
            'type' => 'success',
            'model' => 'toast',
            'title' => 'User Created',
        ],
        'user-updated' => [
            'message' => 'User has been updated successfully.',
            'type' => 'success',
            'model' => 'toast',
            'title' => 'User Updated',
        ],
        'user-deleted' => [
            'message' => 'User has been deleted successfully.',
            'type' => 'success',
            'model' => 'toast',
            'title' => 'User Deleted',
        ],
        'error' => [
            'message' => '',
            'type' => 'error',
            'model' => 'toast',
            'title' => '',
        ],
    ],

];
