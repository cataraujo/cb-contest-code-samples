// copy text to tempfile, store file in other location
<html>

<body>
<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require '../../../database.php';
require '../../PHPThreadControler.php';

define("MAIN_FILE_LOCATION","./webdav/");
define("PAGE_SIZE",'1000');




$listofFiles = array();
function getEmailsToBeSent(){
    global $dbcon;
    $sql = " Select count(email) as total from contacts where invited=1; ";
    $result = $dbcon->query($sql);

    if($result !== False && $result->num_rows==1){
        
            $arr = $result->fetch_assoc();
            return $arr['total'];
    }
    return 0;
}


function getEmail($elem){
    return $elem['email'];
}

function createCSVFiles($pageIndex){

    global $dbcon;
    global $listofFiles;
    $pageIndex*= (int)PAGE_SIZE;  
    $pageSize = (int)PAGE_SIZE;
    $sql = " SELECT email from contacts where invited=1 limit {$pageIndex}, {$pageSize}";
    $result = $dbcon->query($sql);
  
    if($result !== FALSE && $result->num_rows>0){
            $arr = array_map('getEmail',$result->fetch_all(MYSQLI_ASSOC));
  
    $myfile = fopen(MAIN_FILE_LOCATION."tempfile{$pageIndex}.csv", "w") or die("Unable to open file!");
    $txt = implode(',', $arr);

    fwrite($myfile, $txt);
    fclose($myfile);

    }

    array_push($listofFiles,MAIN_FILE_LOCATION."tempfile{$pageIndex}.csv");
    
    var_dump($listofFiles);
}

function devideAndConquerEmails(){
    global $dbcon;
    
    $num_rows = getEmailsToBeSent();

    $totalFiles = $num_rows/(int)PAGE_SIZE + ($num_rows%(int)PAGE_SIZE>0)? 1 : 0;
    echo $totalFiles;
        for($i=0; $i<$totalFiles;$i++){
            echo "Creating files";
            createCSVFiles($i);

        }


}



function executeEmailSend(){

    global $listofFiles;

    $implodeArray = implode(';',$listofFiles);
    echo $implodeArray;
    $command = "C:\php\php.exe ./sample2-read2.php {$implodeArray}";
    
    $phpthread = runCommand($command);
  
    return $phpthread;
}
?>

<?php 


if(isset($_POST['processPID'])){
$thread = getstatus( htmlspecialChars($_POST['processPID']));

echo "<pre> Process is in progress:" .($thread?"True":"False")."</pre>";
?>
<form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST" >

<input type="hidden" name="processPID" value="<?php echo $_POST['processPID']; ?>"/>
<button type="submit">Check Status!!</button>
</form>
<?php

}else if(isset(htmlspecialChars($_POST['sendEmail']))){

if( file_exists(MAIN_FILE_LOCATION)){
    $files = glob(MAIN_FILE_LOCATION.'*'); 
    foreach($files as $file){
        if(is_file($file))
                unlink($file); 
    }
}else{
    mkdir(MAIN_FILE_LOCATION);
}

$dbcon = new mysqli(SERVERNAME, USERNAME, PASSWORD, DATABASE);

devideAndConquerEmails();
$thread = executeEmailSend();

echo "<pre> Process is in progress:" .(getstatus($thread)?"True":"False")."</pre>";
$dbcon->close(); 
?>
<form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST" >

<input type="hidden" name="processPID" value="<?php echo $thread; ?>"/>
<button type="submit">Check Status!!</button>
</form>
<?php
}else{
?>
<form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST" >
<input type="hidden" name="sendEmail" value="true"/>
<button type="submit">Send Emails</button>
</form>
<?php } ?>



</body>
</html>