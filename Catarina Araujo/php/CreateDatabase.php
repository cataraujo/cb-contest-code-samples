<?php
require 'database.php';

$sql = "DROP TABLE IF EXISTS contacts; " .
            " CREATE TABLE `contacts` ( " .
         "   `contactid` int PRIMARY KEY NOT NULL AUTO_INCREMENT, " .
         "   `name`  varchar(200), " .
         "   `email` varchar(256) not null unique," .
         "   `invited` boolean not null" .
        ");".
        "INSERT INTO `contacts`(`email`,`invited`) values ('max.musterman@muster.com',1);".
        "INSERT INTO `contacts`(`email`,`invited`) values ('jonh.doe@muster.com',1);".
        "INSERT INTO `contacts`(`email`,`invited`) values ('mila.musterman@muster.com',1);".
        "INSERT INTO `contacts`(`email`,`invited`) values ('jane.doe@muster.com',1);" ;

$sql .= "DROP TABLE IF EXISTS tokenControle; " .
            " CREATE TABLE `tokenControle` ( " .
         "   `tokenid` int PRIMARY KEY NOT NULL AUTO_INCREMENT, " .
         "   `userid` int not null ," .
         "   `_CSRtoken` text not null,".
         "    `creationdate` timestamp not null,".
         "    `expirationdate` timestamp not null ".
        ");";

$sql .= "DROP TABLE IF EXISTS users; " .
     " CREATE TABLE `users` ( " .
     "   `userid` int PRIMARY KEY NOT NULL AUTO_INCREMENT, " .
     "   `username` varchar(100) not null unique, " .
     "    `password` text not null, ".
     "    `salt` text not null  "-
    ");";

        $sql .= "DROP TABLE IF EXISTS filelocations; " .
        " CREATE TABLE `filelocations` ( " .
     "   `fileid` int PRIMARY KEY NOT NULL AUTO_INCREMENT, " .
     "   `filepath` varchar(100) " .
    ");".
    "INSERT INTO `filelocations`(`filepath`) values ('./filelocation/file1.txt');".
    "INSERT INTO `filelocations`(`filepath`) values ('./filelocation/file2.txt');".
    "INSERT INTO `filelocations`(`filepath`) values ('./filelocation/file3.txt');" ;

 $sql.= "DROP TABLE IF EXISTS marketBalance; " .
        " CREATE TABLE `marketBalance` ( " .
     "   `fruitID` varchar(20) PRIMARY KEY, " .
     "   `avaliableQuantity` int " .
    ");".
    "INSERT INTO `marketBalance`(`fruitID`,`avaliableQuantity`) values ('Banana',1800);".
    "INSERT INTO `marketBalance`(`fruitID`,`avaliableQuantity`) values ('Apple',9600);" .
    "INSERT INTO `marketBalance`(`fruitID`,`avaliableQuantity`) values ('Pineapple',2850);";
  
    echo $sql;

    $dbcon = new mysqli(SERVERNAME, USERNAME, PASSWORD, DATABASE);
    if (mysqli_connect_errno()) {
        printf("Connect failed: %s\n", mysqli_connect_error());
        exit();
    }
    
    $dbcon->begin_transaction();

    if($dbcon->multi_query($sql) == TRUE){
        $dbcon->commit();
        
        echo "Database added with success</br>";
       
    }
    else{
        printf("Connect failed: %s\n",$dbcon->error);
    }     

    
    $dbcon->close();
?>