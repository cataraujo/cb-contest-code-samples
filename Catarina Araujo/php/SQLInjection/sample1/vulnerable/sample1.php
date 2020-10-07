

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

require  '../../../database.php';

if(isset($_FILES['file'])){
$tmpName = $_FILES['file']['tmp_name'];
$csvAsArray = array_map('str_getcsv', file($tmpName));

$dbcon = new mysqli(SERVERNAME, USERNAME, PASSWORD, DATABASE);



echo "<table>";

foreach($csvAsArray as $key=>$value){
    echo "<tr>";
            foreach($value as $val){

            echo "<td>".$val."</td>";
            }
    echo "</tr>";

}


echo "</table>";

}


function importCsvToDatabase($csvArray){

    global $dbcon;
         $sql = createSqlString($csvArray);
            if ($dbcon->multi_query($sql) === TRUE) {
                return "New records created successfully";
              } else {
                
                throw new Exception(  $sql . "<br>" . $dbcon->error);
              }

}


function createSqlString($csvTable){
    $sql = "";
    foreach($csvTable as $value){

        $sql.= "Insert into contacts (`email`,`invited`) value (".$value[0].",1); ";

    }
    return $sql;
}


echo importCsvToDatabase($csvArray);
$dbcon->close();
?>

</body>
</html>