
    <?php 
    $command = "ls -alh".escapeshellarg(';','', $_GET['path']);
    passthru($command);
    ?>
    