<?php

return [

    'api_key' => env('OPENAI_API_KEY'),

    'organization' => env('OPENAI_ORGANIZATION'),

    'base_uri' => env('OPENAI_BASE_URI', 'https://api.openai.com/v1'),

    'request_timeout' => env('OPENAI_REQUEST_TIMEOUT', 30),

];

