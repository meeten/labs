<?php
$numbers = [1, 2, 3, 4, 5];
$average = array_sum($numbers) / count($numbers);
echo "Среднее арифметическое: $average\n";

$sum = array_sum(range(1, 100));
echo "Сумма чисел от 1 до 100: $sum\n";

$numbers = [1, 4, 9, 16, 25]; // Пример массива
$squareRoots = array_map('sqrt', $numbers);
print_r($squareRoots);

$letters = range('a', 'z');
$numbers = range(1, 26);
$array = array_combine($letters, $numbers);
print_r($array);

$numbers = '1234567890';
$pairs = str_split($numbers, 2);
$sumOfPairs = array_sum($pairs);
echo "Сумма пар чисел: $sumOfPairs\n";
?>