<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Ввод данных о блюде</title>
</head>
<body>
    <h1>Введите данные о блюде</h1>
    <form method="post" action="save.php">
        <label>Название блюда:</label>
        <input type="text" name="dish_name" required><br><br>
        
        <label>Ингредиенты:</label>
        <textarea name="ingredients" required></textarea><br><br>
        
        <label>Время приготовления (минуты):</label>
        <input type="number" name="cooking_time" required><br><br>
        
        <input type="submit" value="Сохранить">
    </form>
</body>
</html>