<?php

use humhub\modules\gravatar\Events;

return [
    'id' => 'gravatar',
    'class' => 'humhub\modules\gravatar\Module',
    'namespace' => 'humhub\modules\gravatar',
    'events' => [
        [
            'class' => \humhub\components\Application::class,
            'event' => \humhub\components\Application::EVENT_BEFORE_REQUEST,
            'callback' => [Events::class, 'bootstrap']
        ],
    ],
];