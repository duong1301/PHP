<?php
include('../config/connect.php');
$date = getdate();
$GLOBALS["schoolYear"] = $date["year"];
echo $date["month"];
$GLOBALS["semester"] = 1;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="App.css">
    <title>Document</title>
    
</head>

<body>
    <?php
        include_once('App.php');
    ?>

</body>

</html>