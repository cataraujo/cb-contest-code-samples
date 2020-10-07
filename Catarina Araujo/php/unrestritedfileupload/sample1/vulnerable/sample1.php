<?php


$target = "pictures/" . basename($_FILES['filename']['name']);

if(move_uploaded_file($_FILES['filename']['tmp_name'], $target))
{
echo "The picture has been successfully uploaded.";
}
else
{
echo "There was an error uploading the picture, please try again.";
}


?>

<form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post" enctype="multipart/form-data">

Choose a file to upload:
<input type="file" name="filename"/>
<br/>
<input type="submit" name="submit" value="Submit"/>

</form>