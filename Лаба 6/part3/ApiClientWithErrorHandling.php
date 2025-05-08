<?php
/**
 * Усовершенствованный HTTP-клиент с обработкой ошибок
 */

class ApiResponse {
    public int $statusCode;
    public ?array $data;
    public ?string $error;

    public function __construct(int $statusCode, ?array $data = null, ?string $error = null) {
        $this->statusCode = $statusCode;
        $this->data = $data;
        $this->error = $error;
    }

    public function isSuccess(): bool {
        return $this->statusCode >= 200 && $this->statusCode < 300;
    }
}

/**
 * Выполняет HTTP-запрос с полной обработкой ошибок
 */
function makeHttpRequest(
    string $url,
    string $method = 'GET',
    array $data = null,
    array $headers = []
): ApiResponse {
    $curl = curl_init();

    $options = [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HEADER => false,
        CURLOPT_HTTPHEADER => array_merge([
            'Accept: application/json',
        ], $headers),
        CURLOPT_CUSTOMREQUEST => strtoupper($method),
    ];

    if ($data !== null) {
        $options[CURLOPT_POSTFIELDS] = json_encode($data);
        $options[CURLOPT_HTTPHEADER][] = 'Content-Type: application/json';
    }

    curl_setopt_array($curl, $options);

    $response = curl_exec($curl);
    $statusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    $error = curl_error($curl);
    curl_close($curl);

    if ($error) {
        return new ApiResponse(0, null, "cURL Error: $error");
    }

    $decoded = json_decode($response, true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        return new ApiResponse($statusCode, null, "Invalid JSON response");
    }

    if ($statusCode >= 400) {
        $errorMessage = $decoded['message'] ?? 'HTTP Error';
        return new ApiResponse($statusCode, $decoded, $errorMessage);
    }

    return new ApiResponse($statusCode, $decoded);
}

// 1. Успешный GET-запрос
$response1 = makeHttpRequest('https://jsonplaceholder.typicode.com/posts/1');
if ($response1->isSuccess()) {
    echo "Success! Data: " . print_r($response1->data, true) . "\n";
} else {
    echo "Error {$response1->statusCode}: {$response1->error}\n";
}

// 2. POST с обработкой ошибок
$response2 = makeHttpRequest(
    'https://jsonplaceholder.typicode.com/posts',
    'POST',
    ['title' => 'Test', 'body' => 'Content', 'userId' => 1]
);

// 3. Запрос с неверным URL (имитация ошибки)
$response3 = makeHttpRequest('https://jsonplaceholder.typicode.com/nonexistent');
if (!$response3->isSuccess()) {
    echo "\nError Example:\n";
    echo "Status: {$response3->statusCode}\n";
    echo "Message: {$response3->error}\n";
    if ($response3->data) {
        echo "Details: " . print_r($response3->data, true) . "\n";
    }
}