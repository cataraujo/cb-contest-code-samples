
<?php
require '../../../database.php';


if(isset($_GET['fruitID']) && isset($_GET['quantity'])){

    $seconds = rand(1, 10);
    $nanoseconds = rand(100, 1000000000);
    time_nanosleep($seconds, $nanoseconds);

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
	
	$sql = "SELECT avaliableQuantity FROM marketBalance where fruitID = '{$fruitID}';";

	$prepare = $dbcon->prepare($sql);
	$prepare->bind_param("s",$fruitID);
	$result = $prepare->execute()?$prepare->getResult():NULL;
	if($result !== NULL && $result->num_rows === 1)
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
	
	   $sql = "UPDATE marketBalance SET avaliableQuantity = ? where fruitID = ? ;";
	   $prepare = $dbcon->prepare($sql);
	   $prepare->bind_param("is",$avaliableQuantity,$fruitID);
	   $result = $prepare->execute();
	   if($result ==TRUE)
	   	return  "Fruit has been purchased!!";


   }
   
       return "Fruit is not avaliable";

}

buyFruit($fruitID, $quantity);

$dbcon->close();
} else{
 echo "no param";

}

?>