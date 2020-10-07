<html>

<body>
    
<?php 

$dir = join(DIRECTORY_SEPARATOR,array(".","fileDirectory"));

if(isset($_GET['file'])){
$fullpath = realpath($_GET['file']);

if (file_exists($fullpath)) {
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="'.basename($fullpath).'"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($fullpath));
    readfile($fullpath);
    exit;
}

}
else if ( isset($_GET['directory'])){
        $directory = $_GET['directory'];

        echo listDirectoriesAndFileLinks($directory);
}else{
        echo  listDirectoriesAndFileLinks($dir);
}

    function listDirectoriesAndFileLinks($dir){

        if(file_exists($dir)){

            $files = scandir($dir);

            $str = "";
            foreach($files as $key => $value ){

                if($value === "." || $value === "..") continue;
                $fullpath = join(DIRECTORY_SEPARATOR,array($dir,$value));
                if(is_dir($fullpath)){

                 $str.=  '<a href="'.$_SERVER["PHP_SELF"].'?directory='.$fullpath.'">'.$value.'</a><br>';
                }else{

                    $str.=   '<a href="'.$_SERVER["PHP_SELF"].'?file='.$fullpath.'">'.$value.'</a><br>';
                }

            }
                return $str;
    }



    }



?>


</body>

</html>