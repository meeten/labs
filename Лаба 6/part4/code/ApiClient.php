<?php
/**
 * Класс для работы с API
 */
class ApiClient
{
    private string $baseUrl;
    private array $defaultHeaders = [];
    private ?string $authToken = null;
    private string $authType = 'none';

    /**
     * @param string $baseUrl Базовый URL API
     */
    public function __construct(string $baseUrl)
    {
        $this->baseUrl = rtrim($baseUrl, '/');
    }

    /**
     * Установка базовой аутентификации
     */
    public function setBasicAuth(string $username, string $password): void
    {
        $this->authType = 'basic';
        $this->defaultHeaders['Authorization'] = 'Basic ' . base64_encode("$username:$password");
    }

    /**
     * Установка Bearer токена
     */
    public function setBearerToken(string $token): void
    {
        $this->authType = 'bearer';
        $this->defaultHeaders['Authorization'] = "Bearer $token";
    }

    /**
     * Добавление заголовка по умолчанию
     */
    public function addDefaultHeader(string $name, string $value): void
    {
        $this->defaultHeaders[$name] = $value;
    }

    /**
     * Выполнение HTTP-запроса
     */
    public function request(
        string $method,
        string $endpoint,
        array $data = null,
        array $queryParams = [],
        array $headers = []
    ): array {
        $url = $this->baseUrl . '/' . ltrim($endpoint, '/');
        if (!empty($queryParams)) {
            $url .= '?' . http_build_query($queryParams);
        }

        // Объединение заголовков
        $finalHeaders = array_merge($this->defaultHeaders, $headers);
        $headerStrings = [];
        foreach ($finalHeaders as $name => $value) {
            $headerStrings[] = "$name: $value";
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headerStrings);

        // Настройка метода и данных
        switch (strtoupper($method)) {
            case 'POST':
                curl_setopt($ch, CURLOPT_POST, true);
                break;
            case 'PUT':
            case 'PATCH':
            case 'DELETE':
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, strtoupper($method));
                break;
        }

        if ($data !== null) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        }

        $response = curl_exec($ch);
        $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);

        if ($error) {
            throw new RuntimeException("cURL error: $error");
        }

        $result = json_decode($response, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new RuntimeException("Invalid JSON response");
        }

        if ($statusCode >= 400) {
            $errorMsg = $result['message'] ?? 'API request failed';
            throw new RuntimeException("API error ($statusCode): $errorMsg", $statusCode);
        }

        return $result;
    }

    /**
     * GET запрос
     */
    public function get(string $endpoint, array $queryParams = [], array $headers = []): array
    {
        return $this->request('GET', $endpoint, null, $queryParams, $headers);
    }

    /**
     * POST запрос
     */
    public function post(string $endpoint, array $data, array $headers = []): array
    {
        return $this->request('POST', $endpoint, $data, [], $headers);
    }

    /**
     * PUT запрос
     */
    public function put(string $endpoint, array $data, array $headers = []): array
    {
        return $this->request('PUT', $endpoint, $data, [], $headers);
    }

    /**
     * DELETE запрос
     */
    public function delete(string $endpoint, array $headers = []): array
    {
        return $this->request('DELETE', $endpoint, null, [], $headers);
    }
}