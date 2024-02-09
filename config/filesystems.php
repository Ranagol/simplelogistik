<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default filesystem disk that should be used
    | by the framework. The "local" disk, as well as a variety of cloud
    | based disks are available to your application. Just store away!
    |
    */

    'default' => env('FILESYSTEM_DISK', 'local'),

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    |
    | Here you may configure as many filesystem "disks" as you wish, and you
    | may even configure multiple disks of the same driver. Defaults have
    | been set up for each driver as an example of the required values.
    |
    | Supported Drivers: "local", "ftp", "sftp", "s3"
    |
    */

    'disks' => [

        'local' => [
            
            'driver' => 'local',

            /**
             * storage_path() returns the absolute path to the storage directory in your Laravel 
             * project. Example:
             * dd(storage_path('app'));//"/var/www/html/storage/app"
             */
            'root' => storage_path('app'),

            /**
             * If 'throw' => false, it means that the application should fail silently (i.e., not 
             * throw an exception) when a filesystem operation fails. If 'throw' => true, it means 
             * that the application should throw an exception when a filesystem operation fails.
             */
            'throw' => true,
        ],

        // 'ftp' => [
        //     'driver' => 'ftp',
        //     'host' => env('FTP_HOST'),
        //     'username' => env('FTP_USERNAME'),
        //     'password' => env('FTP_PASSWORD'),
        //     'port' => env('FTP_PORT', 7876),
         
        //     // Optional FTP Settings...
        //     // 'root' => env('FTP_ROOT'),
        //     // 'passive' => true,
        //     // 'ssl' => true,
        //     // 'timeout' => 30,
        // ],

        'sftp' => [
            'driver' => 'sftp',
            'host' => env('SFTP_HOST'),
            'username' => env('SFTP_USERNAME'),
            'password' => env('SFTP_PASSWORD'),
            'port' => intval(env('SFTP_PORT', 7876)),
            'throw' => true

         
            // Settings for SSH key based authentication with encryption password...
            // 'privateKey' => env('SFTP_PRIVATE_KEY'),
            // 'passphrase' => env('SFTP_PASSPHRASE'),
         
            // Settings for file / directory permissions...
            // 'visibility' => 'private', // `private` = 0600, `public` = 0644
            // 'directory_visibility' => 'private', // `private` = 0700, `public` = 0755
         
            // Optional SFTP Settings...
            // 'hostFingerprint' => env('SFTP_HOST_FINGERPRINT'),
            // 'maxTries' => 4,
            // 'passphrase' => env('SFTP_PASSPHRASE'),
            // 'root' => env('SFTP_ROOT', ''),
            // 'timeout' => 30,
            // 'useAgent' => true,
        ],

        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'url' => env('APP_URL').'/storage',
            'visibility' => 'public',
            'throw' => false,
        ],

        's3' => [
            'driver' => 's3',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION'),
            'bucket' => env('AWS_BUCKET'),
            'url' => env('AWS_URL'),
            'endpoint' => env('AWS_ENDPOINT'),
            'use_path_style_endpoint' => env('AWS_USE_PATH_STYLE_ENDPOINT', false),
            'throw' => false,
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Symbolic Links
    |--------------------------------------------------------------------------
    |
    | Here you may configure the symbolic links that will be created when the
    | `storage:link` Artisan command is executed. The array keys should be
    | the locations of the links and the values should be their targets.
    |
    */

    'links' => [
        public_path('storage') => storage_path('app/public'),
    ],

];
