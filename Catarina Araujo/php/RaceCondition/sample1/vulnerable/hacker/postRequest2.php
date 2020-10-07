#!C:\php\php.exe -q
<?php
$url = 'http://localhost/php/RaceCondition/sample1/vulnerable/sample1.php?fruitID=Banana&quantity=10';
$result = file_get_contents($url);
var_dump($result);

?>