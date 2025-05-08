<?php
/**
 * Функция для выполнения HTTP-запросов через cURL
 *
 * @param string $url Адрес запроса
 * @param string $method HTTP-метод (GET, POST, PUT, DELETE)
 * @param array|null $data Данные для отправки (для POST/PUT)
 * @return string Ответ сервера
 */
function sendHttpRequest($url, $method = 'GET', $data = null)
{
    $curlHandler = curl_init();

    curl_setopt($curlHandler, CURLOPT_URL, $url);
    curl_setopt($curlHandler, CURLOPT_RETURNTRANSFER, true);

    switch (strtoupper($method)) {
        case 'POST':
            curl_setopt($curlHandler, CURLOPT_POST, true);
            break;
        case 'PUT':
        case 'DELETE':
            curl_setopt($curlHandler, CURLOPT_CUSTOMREQUEST, $method);
            break;
    }

    if (!empty($data)) {
        curl_setopt($curlHandler, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Accept: application/json'
        ]);
        curl_setopt($curlHandler, CURLOPT_POSTFIELDS, json_encode($data));
    }

    $response = curl_exec($curlHandler);

    curl_close($curlHandler);

    return $response;
}

$apiEndpoint = 'https://jsonplaceholder.typicode.com/posts';

// 1. GET-запрос
$getResponse = sendHttpRequest($apiEndpoint . '/1');
echo "Результат GET-запроса:\n" . $getResponse . "\n\n";

// 2. POST-запрос
$postData = [
    'title' => 'Новый пост',
    'body' => 'Содержание нового поста',
    'userId' => 5
];
$postResponse = sendHttpRequest($apiEndpoint, 'POST', $postData);
echo "Результат POST-запроса:\n" . $postResponse . "\n\n";

// 3. PUT-запрос
$putData = [
    'id' => 1,
    'title' => 'Обновленный заголовок',
    'body' => 'Обновленное содержание',
    'userId' => 1
];
$putResponse = sendHttpRequest($apiEndpoint . '/1', 'PUT', $putData);
echo "Результат PUT-запроса:\n" . $putResponse . "\n\n";

// 4. DELETE-запрос
$deleteResponse = sendHttpRequest($apiEndpoint . '/1', 'DELETE');
echo "Результат DELETE-запроса:\n" . $deleteResponse . "\n\n";
?>