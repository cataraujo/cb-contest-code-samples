<?php

//database credentials for MySQL
define("SERVERNAME", "localhost");
define("USERNAME", "myuser");
define("PASSWORD", "123456");
define("DATABASE", "test");

define("MAIN_FILE_LOCATION","C:/xampp/htdocs/php/webdav/");
define("PAGE_SIZE",1000);

session_start();
$dbconn =  new mysqli(SERVERNAME, USERNAME, PASSWORD, DATABASE);
?>