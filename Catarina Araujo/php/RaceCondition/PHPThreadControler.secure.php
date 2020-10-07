<?php 
 function runCommand($command){
     $command = escapeshellcmd(escapeshellarg($command));
      //  echo "C:/PSTools/psexec.exe -d ".$command."2>&1" ;
        exec("C:/PSTools/psexec.exe  -d ${command} 2>&1", $output);
        preg_match('/ID (\d+)/', implode(";",$output), $matches);
        $pid = $matches[1];
        echo $pid;
        return $pid;
}

function getstatus($pid){
    $pid = escapeshellcmd(escapeshellarg($pid));
    $command = "C:/PSTools/pslist.exe ${pid} 2>&1";
    exec($command,$op);
    preg_match("/process (\d+) was not found/", implode(";",$op), $matches);
    if (isset($matches[1]))return false;
    else return true;
}

function killCommand($pid){
    $pid = escapeshellcmd(escapeshellarg($pid));
    $command = 'Taskkill /f /PID '.$pid;
    exec($command);
    if (getstatus($pid) == false)return true;
    else return false;
}

?>