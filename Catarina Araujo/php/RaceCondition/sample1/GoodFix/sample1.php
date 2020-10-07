<?php
require '../../../database.php';
require '../../semphores.php';

if(isset($_GET['fruitID']) && isset($_GET['quantity'])){

$fruitID= $_GET['fruitID'] ;
$quantity =  $_GET['quantity'] ;
$dbcon = new mysqli(SERVERNAME, USERNAME, PASSWORD, DATABASE);

function getAvaliableQuantityOfFruit($fruitID)
{
	global $dbcon;
	
	$sql = "SELECT avaliableQuantity FROM marketBalance where fruitID = '{$fruitID}';";

	$result = $dbcon->query($sql);
	if($result !== NULL && $result->num_rows === 1)
	{
		$row = $result->fetch_assoc();
		return $row['avaliableQuantity'];
	}
	return 0;
}


function buyFruit($fruitID,$quantity)
{
    $sem = sem_get(2003, 1);
    if (sem_acquire($sem))
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
    }
    sem_release($sem);
    return "Fruit is not avaliable";

   
}

echo buyFruit($fruitID, $quantity);

$dbcon->close();

}
else{

    echo "Missing PARAM";
}
?>