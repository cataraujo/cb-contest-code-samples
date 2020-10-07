<?php
require '../../../database.php';


if(isset($_GET['fruitID']) && isset($_GET['quantity'])){

$fruitID= $_GET['fruitID'] ;
$quantity =  $_GET['quantity'] ;
$dbcon = new mysqli(SERVERNAME, USERNAME, PASSWORD, DATABASE);


function buyAvaliableQuantityOfFruit($fruitID, $value)
{
	global $dbcon;
	
    $sql = "UPDATE marketBalance SET avaliableQuantity = avaliableQuantity - ? where fruitID = ? &&  avaliableQuantity >= ?; ";
    $dbcon->begin_transaction();
    $prepare = $dbcon->prepare($sql);
    $prepare->bind_param("isi",$value,$fruitID,$value);
    $result = $prepare->execute()?$prepare->getResult():false;
    $dbcon->commit();
    echo $result;
	return $result;
}

function buyFruit($fruitID,$quantity)
{

   if(buyAvaliableQuantityOfFruit($fruitID, $quantity) === TRUE)
   {
       return "Fruit is purchased with success!!";
   }
   else
   {
         return "Fruit is not avaliable";
   }
}

echo buyFruit($fruitID, $quantity);

$dbcon->close();

}
else{

    echo "Missing param";
}
?>