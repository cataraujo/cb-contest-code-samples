 <?php 
    $command = "ls -alh". $_GET['path'];
    passthru($command);
?>
    
