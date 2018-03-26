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
if(!isset($_SESSION['usertype']) || empty($_SESSION['usertype']) || !($_SESSION['usertype'] == "salesRep")){
header("location: login.php");
exit;
}

//Database
$sql = "SELECT * FROM clientinfo";
$result = mysqli_query($mysqli, $sql) or die("could not perform query");

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
}else if(isset($_POST["delete"])){
    $id = $_POST["deleteID"];
    $sqlOutput = "DELETE FROM clientinfo WHERE id='$id'";
    $mysqli->query($sqlOutput);

    echo("<script>window.location = 'salesRep.php';</script>");
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
    <h2>Sales rep page!</h2>
    <form method="post" action="salesRep.php">
        <input type="submit" value="View All" name="viewAll">
        <input type="submit" value="Current Month Only" name="thisMonth">
        
    </form>
    
    <table>
        <tr><td>ID</td><td>First Name</td><td>Last Name</td><td>Phone Number</td><td>Email</td><td>Street Address</td><td>City</td><td>Province</td><td>Postal Code</td><td>DOB</td></tr>
    <?php
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
        First name:<br>
        <input type="text" name="firstName" placeholder="First Name">
        <br>
        Last name:<br>
        <input type="text" name="lastName" placeholder="Last Name">
        <br>
        Phone Number:<br>
        <input type="text" name="phone" placeholder="Phone Number">
        <br>
        Email:<br>
        <input type="text" name="email" placeholder="Email">
        <br>
        Street Address:<br>
        <input type="text" name="address" placeholder="Street Address">
        <br>
        City:<br>
        <input type="text" name="city" placeholder="City">
        <br>
        Province:<br>
        <input type="text" name="province" placeholder="Province">
        <br>
        Postal Code:<br>
        <input type="text" name="postal" placeholder="Postal Code">
        <br>
        Date of Birth:<br>
        <input type="date" name="birthday" placeholder="Date of Birth">
        <br><br>
        <input type="submit" value="Add Client" name="addClient">
    </form> 
</body>

</html>