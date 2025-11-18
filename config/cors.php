<?php
return [
    'paths' => ['api/*'],

    'allowed_methods' => ['*'],

    'allowed_origins' => [
        'http://127.0.0.1:5500', // Coloque aqui a porta do seu Live Server
        'http://localhost:5500',
    ],
];