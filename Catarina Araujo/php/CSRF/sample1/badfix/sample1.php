<?php

require "../../../config.php";



$dbconn =  new mysqli(SERVERNAME, USERNAME, PASSWORD, DATABASE);

if($_SERVER["REQUEST_METHOD"] === "POST" && isset($_REQUEST["delete_email"]) && $_REQUEST["delete_email"]==="delete_email"){

    if(isset($_POST["name"])){

        $email = htmlspecialchars($_POST["email"]);
        $prepare = $dbconn->prepare("DELETE from contacts where email = :email");
        $prepare->bind_param("s",$email);
        $result = $prepare->execute();
    
    
        if($result>0){
    
            echo "Contact has been deleted!!";
        }else{
          
            echo "You must provide a email!!";
            
        }
    }

    

}else{


    ?>
    <html>
    <head><title>CSRF Token Sample</title></head>
    <body>
      <form method="POST">
        <input type="text" name = "email"/>
        <input type="hidden" name="PHPSESSID" value="<?=session_id()?>">
        <input type="submit" name="delete_contact" value="delete_contact">
      </form>
    </body>
    </html>
    <?php } ?>



?>