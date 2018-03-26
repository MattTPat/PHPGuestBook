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

// Database
$sql = "SELECT * FROM clientinfo";
$result = mysqli_query($mysqli, $sql) or die("could not perform query");

// Checks for new client
if(isset($_POST["addClient"])){
    $firstName = $_POST["firstName"];
    $lastName = $_POST["lastName"];
    $phone = $_POST["phone"];
    $email = $_POST["email"];
    $address = $_POST["address"];
    $city = $_POST["city"];
    $province = $_POST["province"];
    $postal = $_POST["postal"];
    $dob = strtotime($_POST["birthday"]);
    $dob = date('Y-m-d H:i:s', $dob);
    $sqlOutput = "INSERT INTO clientinfo (firstName, lastName, phone, email, address, city, province, postal, dob) VALUES ('$firstName','$lastName','$phone','$email','$address','$city','$province','$postal','$dob')";
    $mysqli->query($sqlOutput);
    
    echo("<script>window.location = 'salesRep.php';</script>");
// Checks for deleted client
}else if(isset($_POST["delete"])){
    $id = $_POST["deleteID"];
    $sqlOutput = "DELETE FROM clientinfo WHERE id='$id'";
    $mysqli->query($sqlOutput);

    echo("<script>window.location = 'salesRep.php';</script>");
// Checks for client edits
}else if(isset($_POST["saveEdit"])){
    $firstName = $_POST["firstName"];
    $lastName = $_POST["lastName"];
    $phone = $_POST["phone"];
    $email = $_POST["email"];
    $address = $_POST["address"];
    $city = $_POST["city"];
    $province = $_POST["province"];
    $postal = $_POST["postal"];
    $dob = strtotime($_POST["birthday"]);
    $dob = date('Y-m-d H:i:s', $dob);

    $id = $_POST["saveID"];
    $sqlOutput = "UPDATE clientinfo SET firstName='$firstName', lastName='$lastName', phone='$phone', email='$email', address='$address', city='$city', province='$province', postal='$postal', dob='$dob' WHERE id='$id'";
    $mysqli->query($sqlOutput);

    echo("<script>window.location = 'salesRep.php';</script>");
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
    <h2>Guest Book</h2>
    <form method="post" action="email.php">
        <input type="submit" value="Send Email" name="sendEmail">
    </form><br>
    <form method="post" action="salesRep.php">
        <input type="submit" value="View All" name="viewAll">
        <input type="submit" value="Current Month Only" name="thisMonth">
    </form>
    
    <table>
        <tr><th>ID</th><th>First Name</th><th>Last Name</th><th>Phone Number</th><th>Email</th><th>Street Address</th><th>City</th><th>Province</th><th>Postal Code</th><th>DOB</th></tr>
    <?php
        // Gets of all the entries from the database
        if(isset($_POST["thisMonth"])){
            $sql = "SELECT * FROM clientinfo WHERE MONTH(dob) = MONTH(CURRENT_DATE())";
            $result = mysqli_query($mysqli, $sql) or die("could not perform query");
            while($row = mysqli_fetch_assoc($result)){   //Creates a loop to loop through results
                echo "<tr><td>" . $row['id'] . "</td><td>" . $row['firstName'] . "</td><td>" . $row['lastName'] . "</td><td>" . $row['phone'] . "</td><td>" . $row['email'] . "</td><td>" . $row['address'] . "</td><td>" . $row['city'] . "</td><td>" . $row['province'] . "</td><td>" . $row['postal'] . "</td><td>" . $row['dob'] . "</td><td><form method='post' action='salesRep.php'><input type='hidden' name='deleteID' value='".$row['id']."'><input type='submit' value='Delete' name='delete'><input type='submit' value='Edit' name='edit'></form></td></tr>";  //$row['index'] the index here is a field name
            }
        }else if(isset($_POST["edit"])){
            $editID = $_POST["deleteID"];
            $sql = "SELECT * FROM clientinfo WHERE id='$editID'";
            $result = mysqli_query($mysqli, $sql) or die("could not perform query");
            $row = mysqli_fetch_assoc($result);
                echo "<form method='post' action='salesRep.php'><tr><td>" . $row['id'] . "</td><td><input type='text' name='firstName' value='". $row['firstName'] ."'></td><td><input type='text' name='lastName' value='". $row['lastName'] ."'></td><td><input type='text' name='phone' value='". $row['phone'] ."'></td><td><input type='text' name='email' value='". $row['email'] ."'></td><td><input type='text' name='address' value='". $row['address'] ."'></td><td><input type='text' name='city' value='". $row['city'] ."'></td><td><input type='text' name='province' value='". $row['province'] ."'></td><td><input type='text' name='postal' value='". $row['postal'] ."'></td><td><input type='text' name='birthday' value='". $row['dob'] ."'></td><td><input type='hidden' name='saveID' value='".$row['id']."'><input type='submit' value='Cancel' name='cancel'><input type='submit' value='Save Edit' name='saveEdit'></form></td></tr>";  //$row['index'] the index here is a field name
            
        }else{
            while($row = mysqli_fetch_assoc($result)){   //Creates a loop to loop through results
                echo "<span id='". $row['id'] ."'><tr><td>" . $row['id'] . "</td><td>" . $row['firstName'] . "</td><td>" . $row['lastName'] . "</td><td>" . $row['phone'] . "</td><td>" . $row['email'] . "</td><td>" . $row['address'] . "</td><td>" . $row['city'] . "</td><td>" . $row['province'] . "</td><td>" . $row['postal'] . "</td><td>" . $row['dob'] . "</td><td><form method='post' action='salesRep.php'><input type='hidden' name='deleteID' value='".$row['id']."'><input type='submit' value='Delete' name='delete'><input type='submit' value='Edit' name='edit'></form></td></tr></span>";  //$row['index'] the index here is a field name
            }
        }
        
    

    ?>
    </table>
    <hr>
    <h2>Add Client</h2>

    <form method="post" action="salesRep.php">
    <table>
        <tr><td>First Name</td><td>Last Name</td><td>Phone Number</td><td>Email</td><td>Street Address</td><td>City</td><td>Province</td><td>Postal Code</td><td>DOB</td></tr>
        <tr><td><input type="text" name="firstName" placeholder="First Name"></td><td><input type="text" name="lastName" placeholder="Last Name"></td><td><input type="text" name="phone" placeholder="Phone Number"></td><td><input type="text" name="email" placeholder="Email"></td><td><input type="text" name="address" placeholder="Street Address"></td><td><input type="text" name="city" placeholder="City"></td><td><input type="text" name="province" placeholder="Province"></td><td><input type="text" name="postal" placeholder="Postal Code"></td><td><input type="date" name="birthday" placeholder="Date of Birth"></td><td><input type="submit" value="Add Client" name="addClient"></td></tr>
        
    </table>
    </form> 
</body>

</html>