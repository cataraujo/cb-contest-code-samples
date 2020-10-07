<?php
require '../../../config.php';

$dbconn = new PDO("mysql:host=".SERVERNAME.";dbname=".DATABASE."",USERNAME,PASSWORD);

if($dbconn){

    echo "You are connected to the database";
}

if(isset($_POST["name"])){
    $name = htmlspecialchars( $_POST["name"]);
    $email = htmlspecialchars($_POST["email"]);
    $contactQuery = $dbconn->prepare("SELECT * from contacts where email = :email");
    $contactQuery->execute(["email"=>$email]);


    if($contactQuery->rowCount()>0){

        echo "Contact Already exists!!";
    }else{
        $updateContact = $dbconn->prepare("Insert into contacts(`name´, `email`, `invited´) values(:name,:email,1);");
       $count = $updateContact->execute(["name"=>$name,"email"=>$email]);
        
       if($count>0){
           echo "contact has been inserted with success";
       }
        
    }
}



?>
<!doctype html>
<html lang="en">
<body>
<form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post" autocomplete="off"> 
<label for="Name">Name:</label>
<input type="text" name="name"/>
<label for="email">Email: </label>
<input type="text" name="email"/> <!-- typing <scritp>alert('hacked'); </scritp> is allowed in the password input-->
<input type="submit"/>
</form>

</body>
</html>