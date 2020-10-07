

<html>
<body>
<?php

if(isset($_POST["name"])){
    echo $_POST["name"];
}

if(isset($_POST["password"])){
    echo $_POST["password"];
}

?>
<form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
Name: <input type="text" name="name">
Password: <input type="password" name="password"> <!-- typing <scritp>alert('hacked'); </scritp> is allowed in the password input-->
<input type="submit">
</form>

</body>
</html>