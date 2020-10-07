
    <?php 
    $command = "ls -alh".str_replace(';','', $_GET['path']);
    passthru($command);
    ?>
