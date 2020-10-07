<?php

require "../../../config.php";






if($_SERVER["REQUEST_METHOD"] === "POST" && isset($_REQUEST["delete_email"]) && $_REQUEST["delete_email"]==="delete_email"){

  if(isset($_SESSION["userID"]) && isset($_SESSION["loggin_token"])){

    $user = new User($_SESSION["userID"]);
    if( !$user->isLogedIn($_SESSION["login_token"])){ die("you are not loggedin!!");} 
 
if( isset($_POST['_CSRFtoken'])
  && isset($_SESSION['_CSRFtoken']) 
  && $user->checkCSRFToken( $_POST['_CSRFtoken'] )
  && $_POST['_CSRFtoken'] == $_SESSION['_CSRFtoken']){

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

    $dbconn->close();
    flush();
    unset($_SESSION['_CSRFtoken']);
  
    session_write_close();

}
}else{
  unset($_SESSION['_CSRFtoken']);
  die("you are not loggedin!!");
}


}else{
 
  die("CSRF Token {$_POST["_CSRFToken"]} is invalid");

}

  

}else{

  
  if(isset($_SESSION["userID"]) && isset($_SESSION["loggin_token"])){

    $user = new User($_SESSION["userID"]);
    if($user->isLogedIn($_SESSION["login_token"])){



      $hash = $user->generateCSRFToken();

  

  $_SESSION['_CSRFToken'] = $hash;
  ?>
  <html>
  <head><title>CSRF Token Sample</title></head>
  <body>
    <form method="POST">
      <input type="text" name = "email"/>
      <input type="hidden" name="PHPSESSID" value="<?=session_id()?>">
      <input type="hidden" name="_CSRFToken" value="<?= $_SESSION['_CSRFToken'] ?>">
      <input type="submit" name="delete_contact" value="delete_contact">
    </form>
  </body>
  </html>
  
  <?php } 
else{
  die("you are not logged in"); //redirect here to login page

}

  }else{
    die("you are not logged in"); //redirect here to login page
  }
  


}


?>