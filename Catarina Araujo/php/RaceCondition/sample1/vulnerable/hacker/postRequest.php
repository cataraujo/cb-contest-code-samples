#!C:\php\php.exe -q
<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);



$pool = new Pool(5);
for($i=0;$i<5;$i){
$pool->submit(new class extends Thread {
	public function run() {
        echo "hello world!!";
$url = 'http://localhost/php/RaceCondition/sample1/vulnerable/sample1.php?fruitID=Banana&quantity=10';
$result = file_get_contents($url);
var_dump($result);

	}
}
);
}


$pool->shutdown();

?>