<?php
function isSumGreaterThanTen($a, $b) {
  return ($a + $b) > 10;
}
echo isSumGreaterThanTen(5, 6) ? 'true' : 'false', "\n";

function areNumbersEqual($a, $b) {
    return $a === $b;
}
echo areNumbersEqual(1, 2) ? 'true' : 'false', "\n";

$test = 0;
echo ($test == 0) ? 'верно' : '', "\n";

$age = 20;
if ($age < 10 || $age > 99) {
    echo "Число меньше 10 или больше 99\n";
} else {
    $sum = array_sum(str_split((string)$age));
    if ($sum <= 9) {
        echo "Сумма цифр однозначна\n";
    } else {
        echo "Сумма цифр двузначна\n";
    }
}

$arr = [1, 2, 3];
if (count($arr) == 3) {
    echo "Сумма элементов массива: " . array_sum($arr) . "\n";
}
?>