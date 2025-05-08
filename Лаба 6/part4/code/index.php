<?php
require_once 'ApiClient.php';


//WeatherApp -> OpenWeatherApi
const API_KEY = '7940519650feecb12dabd02670e02d11';

$city = $_POST['city'] ?? 'London';
$weatherData = null;
$error = null;

try {
    $client = new ApiClient('https://api.openweathermap.org/data/2.5');
    $weatherData = $client->get('/weather', [
        'q' => $city,
        'appid' => API_KEY,
        'units' => 'metric',
        'lang' => 'ru'
    ]);
} catch (Exception $e) {
    $error = "Ошибка: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Погода</title>
</head>
<body>
<h1>Погода в городе</h1>

<form method="POST">
    <input
            type="text"
            name="city"
            placeholder="Введите город (например, Калининград)"
            value="<?= htmlspecialchars($city) ?>"
            required
    >
    <button type="submit">Узнать</button>
</form>

<?php if ($error): ?>
    <p style="color: red;"><?= $error ?></p>
<?php elseif ($weatherData): ?>
    <h2>Погода в <?= htmlspecialchars($weatherData['name']) ?></h2>
    <ul>
        <li>🌡️ Температура: <?= round($weatherData['main']['temp']) ?>°C</li>
        <li>🌬️ Ветер: <?= $weatherData['wind']['speed'] ?> м/с</li>
        <li>💧 Влажность: <?= $weatherData['main']['humidity'] ?>%</li>
        <li>☁️ <?= ucfirst($weatherData['weather'][0]['description']) ?></li>
    </ul>
<?php endif; ?>
</body>
</html>