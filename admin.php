<?php

require_once 'config.php';

// Initialize the session
session_start();
// If session variable is not set it will redirect to login page
if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
header("location: index.php");
exit;
}
// make sure user is correct usertype
if(!isset($_SESSION['usertype']) || empty($_SESSION['usertype']) || !($_SESSION['usertype'] == "admin")){
header("location: login.php");
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

    <form method="post" action="download.php">
        <input type="submit" name="csv" value="Download CSV">
    </form>
          
</body>

</html>