<?php
session_start();

// Проверяем, есть ли данные в сессии
if (!isset($_SESSION['dish_name'])) {
    header('Location: index.php');
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Данные о блюде</title>
</head>
<body>
    <h1>Информация о блюде</h1>
    <p><strong>Название блюда:</strong> <?php echo htmlspecialchars($_SESSION['dish_name']); ?></p>
    <p><strong>Ингредиенты:</strong> <?php echo nl2br(htmlspecialchars($_SESSION['ingredients'])); ?></p>
    <p><strong>Время приготовления:</strong> <?php echo htmlspecialchars($_SESSION['cooking_time']); ?> минут</p>
    
    <a href="index.php">Ввести новые данные</a>
</body>
</html>