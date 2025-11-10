<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Log;

class YandexGPTService
{
    private $client;
    private $config;

    public function __construct()
    {
        $this->client = new Client();
        $this->config = config('yandex_gpt');
    }

    public function sendPrompt(string $prompt, array $options = []): array
    {
        try {
            if (empty($this->config['api_key'])) {
                return [
                    'success' => false,
                    'error' => 'YANDEX_GPT_API_KEY не настроен в .env файле',
                ];
            }

            if (empty($this->config['folder_id'])) {
                return [
                    'success' => false,
                    'error' => 'YANDEX_GPT_FOLDER_ID не настроен в .env файле',
                ];
            }

            $headers = [
                'Content-Type' => 'application/json',
                'Authorization' => 'Api-Key ' . $this->config['api_key'],
            ];

            if (!empty($this->config['folder_id'])) {
                $headers['x-folder-id'] = $this->config['folder_id'];
            }

            $response = $this->client->post($this->config['api_url'], [
                'headers' => $headers,
                'json' => $this->buildPayload($prompt, $options),
                'timeout' => 60,
            ]);

            return $this->handleSuccessResponse($response);

        } catch (RequestException $e) {
            $errorMessage = 'Ошибка при обращении к Yandex GPT API';
            $statusCode = null;
            $responseBody = null;
            
            if ($e->hasResponse()) {
                $response = $e->getResponse();
                $statusCode = $response->getStatusCode();
                $responseBody = $response->getBody()->getContents();
                $body = json_decode($responseBody, true);
                
                if (isset($body['message'])) {
                    $errorMessage = $body['message'];
                } elseif (isset($body['error']['message'])) {
                    $errorMessage = $body['error']['message'];
                }
            }
            
            Log::error('YandexGPT API Error', [
                'error' => $e->getMessage(),
                'status_code' => $statusCode,
                'response' => $responseBody
            ]);
            
            return $this->handleError($e, $errorMessage, $statusCode);
        } catch (\Exception $e) {
            Log::error('YandexGPT Service Error', ['error' => $e->getMessage()]);
            return [
                'success' => false,
                'error' => 'Неожиданная ошибка: ' . $e->getMessage(),
            ];
        }
    }

    private function buildPayload(string $prompt, array $options): array
    {
        return [
            "modelUri" => $this->config['model_uri'],
            "completionOptions" => [
                "stream" => false,
                "temperature" => $options['temperature'] ?? 0.3,
                "maxTokens" => $options['maxTokens'] ?? 2000,
            ],
            "messages" => [
                [
                    "role" => "user",
                    "text" => $prompt
                ]
            ]
        ];
    }

    private function handleSuccessResponse($response): array
    {
        $result = json_decode($response->getBody()->getContents(), true);
        
        if (!isset($result['result']['alternatives'][0]['message']['text'])) {
            Log::error('YandexGPT Invalid Response', ['response' => $result]);
            return [
                'success' => false,
                'error' => 'Неверный формат ответа от API',
            ];
        }
        
        $text = $result['result']['alternatives'][0]['message']['text'];
        $usage = $result['result']['usage'] ?? null;
        $tokensUsed = $usage['totalTokens'] ?? null;
        
        return [
            'success' => true,
            'text' => $text,
            'tokens_used' => $tokensUsed,
            'full_response' => $result
        ];
    }

    private function handleError(RequestException $e, string $errorMessage = null, int $statusCode = null): array
    {
        return [
            'success' => false,
            'error' => $errorMessage ?? 'YandexGPT API Request failed',
            'details' => $e->getMessage(),
            'status_code' => $statusCode ?? ($e->getResponse() ? $e->getResponse()->getStatusCode() : null)
        ];
    }
}