<?php
if (empty($_POST))
{
    header("Location: index.php");
    die();
}

include_once "mysql.php";
//print_r($_POST);

//MySQL-Init
$db = mysqli_connect($host, $user, $pass, $db_name) or die("Error.");
$db->set_charset("utf8");
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

//POST-Variablen
if (isset($_POST['mail'])) { //mail
    $mail=mysqli_real_escape_string($db, $_POST['mail']);
}
if (isset($_POST['password'])) { //password
    $password=mysqli_real_escape_string($db, $_POST['password']);
}

//MySQL Select
$sql = 'SELECT ID, mail, password FROM participants WHERE mail="' . $mail . '"';
$result = $db->query($sql);

if ($result->num_rows > 0) {
  // output data of each row
  /*while($row = $result->fetch_assoc()) {
    echo "mail: " . $row["mail"];
    echo " password: " . $row["password"];
    echo "<br>";
  }*/
  $result_array = mysqli_fetch_array($result);
  $db_password = $result_array[2];
  $user_ID = $result_array[0];
  //echo "results: " . $result->num_rows;
  //echo "<br>";
} else {
  //echo "0 results";
}

if(password_verify($password, $db_password)) {
    $db->close();
    //Passwort korrekt. Login
    //print("Password matched.");
    session_start();
    $_SESSION["userID"] = $user_ID;
    header("Location: ../loggedin.php");
    die();
} else {
    print("Password did not match.");
}

//echo "<br>";
//print_r($result);

$db->close();
?>