
<?php
require '../../../database.php';


if(isset($_GET['fruitID']) && isset($_GET['quantity'])){

	$fruitID= $_GET['fruitID'] ;
	$quantity =  $_GET['quantity'] ;
	$dbcon = new mysqli(SERVERNAME, USERNAME, PASSWORD, DATABASE);

if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}


function getAvaliableQuantityOfFruit($fruitID)
{
	global $dbcon;
	
	$sql = "SELECT avaliableQuantity FROM marketBalance where fruitID like '{$fruitID}';";

	$result = $dbcon->query($sql);
	if($result !== NULL && $result->num_rows >= 1)
	{
		$row = $result->fetch_assoc();
		return $row['avaliableQuantity'];
	}
	return 0;
}


function buyFruit($fruitID, $quantity )
{
   $avaliableQuantity = getAvaliableQuantityOfFruit($fruitID);

   if($quantity <= $avaliableQuantity)
   {
       $avaliableQuantity = $avaliableQuantity - $quantity;
	   global $dbcon;
	
	   $sql = "UPDATE marketBalance SET avaliableQuantity = {$avaliableQuantity} where fruitID like '{$fruitID}';";
	   
	   $result = $dbcon->query( $sql);
	   if($result === TRUE)
	   	return  "Fruit has been purchased!!";


   }
   
       return "Fruit is not avaliable";

}

echo buyFruit($fruitID, $quantity);

$dbcon->close();
} else{
 echo "no param";

}

?>