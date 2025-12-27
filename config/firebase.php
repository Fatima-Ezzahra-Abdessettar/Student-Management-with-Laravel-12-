<?php

declare(strict_types=1);

return [
    'default' => 'app',

    'projects' => [
        'app' => [
            'credentials' => [
                'file' => env('FIREBASE_CREDENTIALS'),
            ],
        ],
    ],
];