<?php

return [
    'api_key' => env('YANDEX_GPT_API_KEY'),
    'folder_id' => env('YANDEX_GPT_FOLDER_ID'),
    'model_uri' => env('YANDEX_GPT_MODEL_URI', 'gpt://b1go5ad00fis264513fb/yandexgpt-5.1/latest'),
    'api_url' => 'https://llm.api.cloud.yandex.net/foundationModels/v1/completion',
];