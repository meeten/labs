<?php
/**
 * Расширенный клиент для HTTP-запросов с поддержкой заголовков, JSON и URL-параметров
 */

/**
 * Выполняет GET-запрос с кастомными заголовками
 *
 * @param string $url Адрес запроса
 * @param array $headers Дополнительные HTTP-заголовки (например, ['Authorization: Bearer token'])
 * @return string Ответ сервера
 */
function fetchWithHeaders(string $url, array $headers = []): string
{
    $curl = curl_init();

    curl_setopt_array($curl, [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => $headers,
    ]);

    $response = curl_exec($curl);
    curl_close($curl);

    return $response;
}

/**
 * Отправляет JSON-данные в теле запроса (POST/PUT)
 *
 * @param string $url Адрес запроса
 * @param string $method HTTP-метод (POST, PUT, PATCH)
 * @param array $data Данные для отправки
 * @return string Ответ сервера
 */
function sendJsonPayload(string $url, string $method, array $data): string
{
    $curl = curl_init();

    curl_setopt_array($curl, [
        CURLOPT_URL => $url,
        CURLOPT_CUSTOMREQUEST => strtoupper($method),
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
        CURLOPT_POSTFIELDS => json_encode($data),
    ]);

    $response = curl_exec($curl);
    curl_close($curl);

    return $response;
}

/**
 * Выполняет запрос с параметрами URL (GET)
 *
 * @param string $baseUrl Базовый URL (без параметров)
 * @param array $queryParams Параметры запроса (например, ['id' => 1, 'sort' => 'asc'])
 * @return string Ответ сервера
 */
function fetchWithQueryParams(string $baseUrl, array $queryParams): string
{
    $url = $baseUrl . '?' . http_build_query($queryParams);
    return file_get_contents($url); // Альтернатива cURL для простых GET-запросов
}

// 1. GET с кастомными заголовками
$headers = [
    'Authorization: Bearer test123',
    'X-Custom-Header: PHP-Lab'
];
echo "GET с заголовками:\n" . fetchWithHeaders('https://jsonplaceholder.typicode.com/posts/1', $headers) . "\n\n";

// 2. Отправка JSON (POST)
$postData = [
    'title' => 'Lab Work',
    'body' => 'HTTP Client in PHP',
    'userId' => 10
];
echo "POST JSON:\n" . sendJsonPayload('https://jsonplaceholder.typicode.com/posts', 'POST', $postData) . "\n\n";

// 3. GET с параметрами URL
$params = [
    'userId' => 1,
    '_limit' => 3
];
echo "GET с параметрами:\n" . fetchWithQueryParams('https://jsonplaceholder.typicode.com/posts', $params) . "\n\n";
?>