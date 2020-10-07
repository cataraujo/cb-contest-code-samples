<?php 
 function runCommand($command){
      //  echo "C:/PSTools/psexec.exe -d ".$command."2>&1" ;
        exec("C:/PSTools/psexec.exe  -d ${command} 2>&1", $output);
        preg_match('/ID (\d+)/', implode(";",$output), $matches);
        $pid = $matches[1];
        echo $pid;
        return $pid;
}

function getstatus($pid){
    $command = "C:/PSTools/pslist.exe ${pid} 2>&1";
    exec($command,$op);
    preg_match("/process (\d+) was not found/", implode(";",$op), $matches);
    if (isset($matches[1]))return false;
    else return true;
}

function killCommand($pid){
    $command = 'Taskkill /f /PID '.$pid;
    exec($command);
    if (getstatus($pid) == false)return true;
    else return false;
}

?>