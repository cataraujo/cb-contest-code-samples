<html>

<body>
   


<?php 

if(isset($_POST['mytext'])){

    $command = "powershell -Command \"(gc myFile.txt) -replace \"".$_POST['mytext']."\" | Out-File myFile.txt \"";

    exec($command);
}

?>

<?php 
$path = "./myfile.txt";
if( file_exists($path)){

    echo file_get_contents($path);
}
?>


<form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST" >

<textarea name="mytext" id="mytext" cols="30" rows="10"></textarea>

<button type="submit">save</button>
</form>

</body>
</html>