<?php
ob_start();
// Include config file
require_once 'config.php';

// init variables
$username = "";
$password = "";
$usertype = "";
$email = "";
$name = "";
$access = "";

$passwordInput = "";

//echo $_POST['theusername'];
//echo $_POST['thepassword'];
if (isset($_POST['theusername'])) {
    $username = $_POST['theusername'];
    //echo "Username!";
}

if (isset($_POST['thepassword'])) {
    $passwordInput = $_POST['thepassword'];
    //secho "Password!";
}

$sql = "SELECT * FROM login WHERE username = '$username'";

$result = mysqli_query($mysqli, $sql) or die("could not perform query");
$row = mysqli_fetch_assoc($result);
$usertype = $row['userType'];
$password = $row['password'];

if(isset($passwordInput) && isset($username)){
    if($passwordInput == $password){
        if($usertype == 'admin'){
            session_start();
            $_SESSION['username'] = $username;
            $_SESSION['usertype'] = $usertype;
            header('Location: admin.php');
            //echo "Admin";
            exit();
        }else if($usertype == 'salesRep'){
            session_start();
            $_SESSION['username'] = $username;
            $_SESSION['usertype'] = $usertype;    
            //echo "Sales Rep";    
            header('Location: salesRep.php');
            
            exit();
        }    
    };
}else{
    //echo "<br>invalid login<br>";
};

$mysqli->close();

?>

<!DOCTYPE html>
<html>
<head>
    <title>Guest Book</title>
    <link rel="stylesheet" type="text/css" href="css/styles.css">
</head>
<body>
    <div class="login">
        <h4>Please enter your username and password</h4>
        <br/><br/>

        <!--<form action="login.php">
            <p>Username:<br><input type="text" name="username" maxlength="20"></p>
            <p>Password:<br><input type="password" name="password" maxlength="20"></p>
            <input type="submit" name="submit" value="Submit">
            <br>                
            <span id="lblFeedback"></span>
        </form>-->
        <form method="post" action="login.php">
            First name:<br>
            <input type="text" name="theusername" value="test">
            <br>
            Last name:<br>
            <input type="text" name="thepassword" value="test">
            <br><br>
            <input type="submit" value="Submit">
        </form> 
           
    </div>
</body>

</html>