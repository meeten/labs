<?php
function increaseEnthusiasm($string): string {
    return $string . "!";
}
echo increaseEnthusiasm("Hello, World") , "\n";

function repeatThreeTimes($string): string {
    return $string . $string . $string;
}
echo repeatThreeTimes("Hi") , "\n";

echo increaseEnthusiasm(repeatThreeTimes("Hello")) , "\n";

function cut($string, $length = 10) {
    return substr($string, 0, $length);
}

echo cut("This is a long string") , "\n";

function printArray($arr, $index = 0) {
    if ($index < count($arr)) {
        echo $arr[$index] . "\n";
        printArray($arr, $index + 1);
    }
}
printArray([-2, 0, 1, 15, 4]);

function sumDigitsSingleDigit(int $number): int {
    while ($number > 9) {
        $number = array_sum(str_split((string) $number));
    }
    return $number;
}
echo sumDigitsSingleDigit(12345) , "\n";
?>