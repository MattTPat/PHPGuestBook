<?php

require_once 'config.php';

session_start();
// Checks to make sure session variable is set
if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
header("location: index.php");
exit;
}
// Checks to see if the user is the right type to access the page
if(!isset($_SESSION['usertype']) || empty($_SESSION['usertype']) || !($_SESSION['usertype'] == "salesRep")){
header("location: index.php");
exit;
}

//Database
$sql = "SELECT email FROM clientinfo";
$result = mysqli_query($mysqli, $sql) or die("could not perform query");
$row = mysqli_fetch_assoc($result);

// Check for email send button press
if(isset($_POST["send"])){
    
    $email = $_POST["email"];
    $sub = $_POST["subject"];
    $msg = $_POST["content"];
    $msg = wordwrap($msg,70);

    mail($email, $sub, $msg);

}elseif(isset($_POST["sendAll"])){
    $sub = $_POST["subject"];
    $msg = $_POST["content"];
    $msg = wordwrap($msg,70);
    $emails = $row["email"];

    while($row = mysqli_fetch_assoc($result)){
        $emails = $emails . "," . $row["email"];
    }
    echo $emails;
    //mail($emails, $sub, $msg);
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
        <h2>Send Email</h2>
        <form method="post" action="email.php">
            Client Email:<br>
            <input type="text" name="email"><br>
            Subject:<br>
            <input type="text" name="subject"><br>
            Content:<br>
            <textarea name="content" rows="10" cols="50"></textarea><br><br>
            <input type="submit" value="Send" name="send">
            <input type="submit" value="Send to all clients" name="sendAll">
            <input type="reset" value="Reset">
        </form><br>
        <a href="salesRep.php"><input type="button" value="Back"></a>
            
    </body>

</html>