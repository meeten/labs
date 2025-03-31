<?php
//вариант 14
$str = 'a1b2c3';

$result = preg_replace_callback(
    '/\d+/',
    function($matches) {
        $number = (int)$matches[0];
        return $number - 5;
    },
    $str
);

echo "Исходная строка: " . $str . "\n";
echo "Результат: " . $result . "\n";
?>