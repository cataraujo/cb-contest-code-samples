<?php 

//Blacklist certain characters in the receivable name double dot, or even just dot.


?>


<?php 
require "../../../config.php";


if(isset($_GET["filename"])){
    $fixedPath = MAIN_FILE_LOCATION;
    $filename = realpath($_GET["filename"]);
    $pathParts = explode("/",$filename);
    $fullpath = $fixedPath.implode("\\",$pathParts);
  
    if (file_exists($fullpath)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="'.basename($fullpath).'"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($filename));
        readfile($filename);
        exit;
    }
}





?>
