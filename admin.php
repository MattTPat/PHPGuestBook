<?php

require_once 'config.php';

session_start();
// Checks to make sure session variable is set
if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
header("location: index.php");
exit;
}
// Checks to see if the user is the right type to access the page
if(!isset($_SESSION['usertype']) || empty($_SESSION['usertype']) || !($_SESSION['usertype'] == "admin")){
header("location: index.php");
exit;
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Guest Book</title>
    <link rel="stylesheet" type="text/css" href="css/styles.css">
</head>
<body>
<form method="post" action="logout.php">
        <input type="submit" value="Log Out" name="logout">
    </form><br>
    <form method="post" action="download.php">
        <input type="submit" name="csv" value="Download CSV">
    </form><br>
    <form action="upload.php" method="post" enctype="multipart/form-data">
        Upload CSV:<br>
        <input type="file" name="fileToUpload" id="fileToUpload"><br>
        <input type="submit" value="Upload" name="upload">
    </form>
          
</body>

</html>