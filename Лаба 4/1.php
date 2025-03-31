<?php
//вариант 14
$str = 'nxyz n123n n---n nabc nnnn nx12ny34n n   n';
$pattern = '/n...n/';

preg_match_all($pattern, $str, $matches);

echo "Найденные совпадения для шаблона 'n...n':\n";
print_r($matches[0]);
?>