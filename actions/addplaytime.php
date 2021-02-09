<?php
session_start();
if (empty($_POST))
{
  echo "POST empty";
    //header("Location: ../index.php");
    //die();
}
if (empty($_SESSION["userID"]))
{
  echo "SESSION empty";
  print_r($_SESSION);
    //header("Location: ../index.php");
    //die();
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
if (isset($_POST['hours'])) { //hours
  $hours=(int)$_POST['hours'];
}
if (isset($_POST['weeknumber'])) { //weeknr
  $weeknumber=(int)$_POST['weeknumber'];
}
if (isset($_SESSION["userID"])) { //userID
  $userID=(int)$_SESSION["userID"];
}

//MySQL Insert
$stmt = $db->prepare("INSERT INTO entries (playerID, weekNumber, playtime) VALUES (?, ?, ?)");
$stmt->bind_param("iii", $userID, $weeknumber, $hours);

//echo($hours . " | " . $weeknumber . " | " . $userID);

$stmt->execute() or die("<br>" . mysqli_error($db));

$maxID = $stmt->insert_id;
//print($maxID);
$stmt->close();

$db->close();


header("Location: ../index.php");
die();

?>