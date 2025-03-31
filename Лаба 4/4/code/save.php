<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_SESSION['dish_name'] = $_POST['dish_name'] ?? '';
    $_SESSION['ingredients'] = $_POST['ingredients'] ?? '';
    $_SESSION['cooking_time'] = $_POST['cooking_time'] ?? '';
    header('Location: display.php');
    exit();
} else {
    header('Location: index.php');
    exit();
}
?>