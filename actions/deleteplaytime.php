<?php
session_start();
if (empty($_GET))
{
  echo "GET empty";
    //header("Location: ../index.php");
    //die();
}
if (empty($_SESSION["userID"]))
{
  echo "SESSION empty";
  print_r($_SESSION);
    //header("Location: ../index.php");
    //die();
} else {
  $userID = $_SESSION["userID"];
}

include_once "mysql.php";
//print_r($_POST);

//GET-Variablen
if (isset($_GET['id'])) { //id
  $playID=(int)$_GET['id'];
}

//MySQL-Init
$db = mysqli_connect($host, $user, $pass, $db_name) or die("Error.");
$db->set_charset("utf8");
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

//MySQL Select
$sql = 'SELECT * FROM entries WHERE ID=' . $playID;
$result = $db->query($sql);

if ($result->num_rows > 0) {
  // output data of each row
  /*while($row = $result->fetch_assoc()) {
    echo "mail: " . $row["mail"];
    echo " password: " . $row["password"];
    echo "<br>";
  }*/
  $result_array = mysqli_fetch_array($result);
  //echo "<script>console.log(" . json_encode($result_array) . ");</script>";
  //print_r($result_array);
  $entryID = $result_array[0];
  $playerID = $result_array[1];
  //echo "results: " . $result->num_rows;
  //echo "<br>";
} else {
  //echo "0 results";
}

$db->close();

if ($playerID != $userID) {
  echo "Keine Berechtigung. PlayerID: " . $playerID . ", userID: " . $userID;
  die();
} else {
  //MySQL-Init
  $db = mysqli_connect($host, $user, $pass, $db_name) or die("Error.");
  $db->set_charset("utf8");
  if ($db->connect_error) {
      die("Connection failed: " . $db->connect_error);
  }

  //MySQL Select
  $sql = 'DELETE FROM entries WHERE ID=' . $playID;
  $result = $db->query($sql);
  //print_r($result);
  $db->close();

  if($result == 1) {
    header("Location: ../index.php");
    die();
  }
}
?>