

<html>
    <head>
    <style>
        table {
        font-family: arial, sans-serif;
        border-collapse: collapse;
        width: 100%;
        }

        td, th {
        border: 1px solid #dddddd;
        text-align: left;
        padding: 8px;
        }

        tr:nth-child(even) {
        background-color: #dddddd;
        }
    </style>
    </head>
<body>

<form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post" enctype="multipart/form-data">
Select file
<input type="file" name="file" id="file" />

<input type="submit" name="submit" />
</form>
<?php
if(isset($_FILES['file'])){
$tmpName = $_FILES['file']['tmp_name'];
$csvAsArray = array_map('str_getcsv', file($tmpName));
var_dump($csvAsArray);


echo "<table>";

foreach($csvAsArray as $key=>$value){
    echo "<tr>";
            foreach($value as $val){

            echo "<td>".htmlspecialchars($val)."</td>";
            }
    echo "</tr>";

}


echo "</table>";

}
?>

</body>
</html>