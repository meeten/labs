<?php
require_once 'ApiClient.php';

// Создаем клиент для JSONPlaceholder API
$client = new ApiClient('https://jsonplaceholder.typicode.com');

try {
    // Пример GET запроса
    echo "=== Получаем пост с ID 1 ===\n";
    $post = $client->get('/posts/1');
    print_r($post);

    // Пример POST запроса
    echo "\n=== Создаем новый пост ===\n";
    $newPost = $client->post('/posts', [
        'title' => 'Мой новый пост',
        'body' => 'Содержание нового поста',
        'userId' => 1
    ]);
    print_r($newPost);

    // Пример PUT запроса
    echo "\n=== Обновляем пост ===\n";
    $updatedPost = $client->put('/posts/1', [
        'id' => 1,
        'title' => 'Обновленный заголовок',
        'body' => 'Обновленное содержание',
        'userId' => 1
    ]);
    print_r($updatedPost);

    // Пример DELETE запроса
    echo "\n=== Удаляем пост ===\n";
    $result = $client->delete('/posts/1');
    print_r($result);

} catch (RuntimeException $e) {
    echo "Ошибка: " . $e->getMessage() . "\n";
    if ($e->getCode() > 0) {
        echo "HTTP статус: " . $e->getCode() . "\n";
    }
}