<?php
// Подключение к серверу MySQL
$mysqli = new mysqli('db', 'root', 'helloworld', 'web', 3306);

if (mysqli_connect_errno()) {
    die("Подключение к серверу MySQL невозможно. Код ошибки: " . mysqli_connect_error());
}

// Обработка формы
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $mysqli->real_escape_string($_POST['email']);
    $title = $mysqli->real_escape_string($_POST['title']);
    $category = $mysqli->real_escape_string($_POST['categories']);
    $description = $mysqli->real_escape_string($_POST['description']);

    $query = "INSERT INTO `ad` (email, title, description, category) VALUES ('$email', '$title', '$description', '$category')";
    if (!$mysqli->query($query)) {
        echo "Ошибка при добавлении объявления: " . $mysqli->error;
    }
}

// Получение всех объявлений
$advertisements = [];
if ($result = $mysqli->query('SELECT * FROM `ad` ORDER BY `created` DESC')) {
    while ($row = $result->fetch_assoc()) {
        $advertisements[] = $row;
    }
    $result->close();
} else {
    echo "Ошибка при получении объявлений: " . $mysqli->error;
}

// Закрытие соединения
$mysqli->close();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Туристические объявления</title>
    <style>
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #ddd; padding: 8px; }
        th { background-color: #f2f2f2; }
        body { font-family: Arial, sans-serif; max-width: 800px; margin: 0 auto; padding: 20px; }
        form { margin-bottom: 30px; background: #f9f9f9; padding: 20px; border-radius: 5px; }
        input, textarea, select { width: 100%; padding: 8px; margin: 5px 0 15px; }
        button { background: #4CAF50; color: white; padding: 10px 15px; border: none; cursor: pointer; }
        button:hover { background: #45a049; }
    </style>
</head>
<body>
<h1>Добавить туристическое объявление</h1>
<form action="index.php" method="post">
    <label for="email">Email</label>
    <input type="email" name="email" required> <br>

    <label for="title">Название предложения</label>
    <input type="text" name="title" required placeholder="Например: Тур в Италию"> <br>

    <label for="category">Категория</label>
    <select name="categories" required>
        <option value="travel">Путешествия</option>
        <option value="vacation">Отдых</option>
        <option value="tours">Туризм</option>
    </select><br>

    <label for="description">Описание</label>
    <textarea rows="5" name="description" required placeholder="Подробное описание вашего предложения..."></textarea> <br>

    <button type="submit">Опубликовать</button>
</form>

<h2>Последние объявления</h2>
<div id="table">
    <table>
        <thead>
        <tr>
            <th>Email</th>
            <th>Название</th>
            <th>Описание</th>
            <th>Категория</th>
            <th>Дата</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($advertisements as $advertisement): ?>
            <tr>
                <td><?= htmlspecialchars($advertisement['email']) ?></td>
                <td><?= htmlspecialchars($advertisement['title']) ?></td>
                <td><?= htmlspecialchars($advertisement['description']) ?></td>
                <td><?= htmlspecialchars($advertisement['category']) ?></td>
                <td><?= htmlspecialchars($advertisement['created']) ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>