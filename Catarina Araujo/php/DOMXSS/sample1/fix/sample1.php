<?php

//http://localhost/samples/cwe/cwe-79/BAD/sample1/improperSanitization.php?name=%3Cscript%3Ealert(%27hacked%27);%3C/script%3E

echo htmlspecialchars($_GET["name"]);


?>