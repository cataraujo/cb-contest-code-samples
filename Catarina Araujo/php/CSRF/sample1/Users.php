<?php

require "../../config.php";


class User {

    private $userid;
    private $username;
    private $password;
    private $salt;

    private $login_token;


    function __construct($userid=False)
    {
        if($userid !== false){

            $this->userid = $userid;
            $this->getUserDetails();
        }
    }


    function getUserDetails(){
         
        global $dbconn;
        $sql = "SELECT username,password,salt from users where userid = ? ";

        $prepare =  $dbconn->prepare($sql);
        $prepare->bind_param("i",$this->userid);

        $result = $prepare->execute()?$prepare->get_result():FALSE;

        if( $result != FALSE){
              $assArray =  $result->fetch_assoc();

              $this->username = $assArray['username'];
              $this->password = $assArray['password'];
              $this->salt = $assArray['salt'];

        }
    }

    public function isLogedIn($login_token){
         //check if user  and token are associated. Check validaty of token

            return true;
    }


    public function loginIn ($username, $password){

        //if user, compare password with hashed password, by hashing given password with salt; 

        return "loginhash";

    }


    public function generateCSRFToken(){
        $hash = sha1("mysecrethash".microtime().rand(1,999999));

         
        $sql = "Insert into tokenControle( `userid`,`_CSRtoken`, `creationdate`, `expirationdate`)".
        " values( ?,?, NOW(),ADDDATE(NOW(), INTERVAL 30 MINUTE);";


        //database 
        return $hash;

    }


    public function checkCSRFToken($csrftoken){
            //check token and expiration

        return false;
    }





}


?>