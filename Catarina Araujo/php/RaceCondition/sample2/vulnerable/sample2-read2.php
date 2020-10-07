<?php
require '../../PHPThreadControler.php';

define('MAX_THREADS','10');

sleep(100000000);
$executing = Array();

$nextTasks = Array();


function createTasks(){


    global $filelist;
    global $nextTasks;
    foreach($filelist as $file){
        $cmd = "C:\php\php.exe ./read.php {$file}";
        array_push($nextTasks,$cmd);

    }

}



if(isset($argv[1])){
    $csvfile = $argv[1];
  
   $filelist = explode(',',$csvfile);
  
     createTasks();

     
    while(count($nextTasks)>0 || count($executing)>0){

    if(count($executing)<(int)MAX_THREADS){
        for($i=0; $i<=(int)MAX_THREADS-count($executing);$i++){
          array_push( $executing,runCommand(array_pop($nextTasks)));
        }
    }

    sleep(1);
    $copy = array();
    for($j=0;$j<count($executing);$j){
        if(!getstatus($executing[$j])){
            array_push(  $copy, $executing[$j]);
        }
    }

    $executing = array_diff($copy, $executing);

}
   
  echo "execution ended";
 }


?>