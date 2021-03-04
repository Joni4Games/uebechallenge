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
if (empty($_SESSION["mail"]))
{
  echo "SESSION empty";
  print_r($_SESSION);
  //header("Location: ../index.php");
  //die();
} else {
  $mailadress = $_SESSION["mail"];
}

include_once "mysql.php";
//print_r($_POST);

//GET-Variablen
if (isset($_GET['id'])) { //id
  $playID=(int)$_GET['id'];
}
//GET-Variablen
if (isset($_GET['time'])) { //time
  $time=(int)$_GET['time'];
}

//MySQL-Init
$db = mysqli_connect($host, $user, $pass, $db_name) or die("Error.");
$db->set_charset("utf8");
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

//MySQL Select
$stmt = $db->prepare('SELECT entries.ID, playerID, supermail FROM entries INNER JOIN participants ON entries.playerID=participants.ID WHERE entries.ID=?');
//$sql = 'SELECT * FROM participants INNER JOIN instruments ON participants.instrument=instruments.ID WHERE participants.ID=' . $userID;
$stmt->bind_param("i", $playID);
$stmt->execute() or die("<br>" . mysqli_error($db));
//$result = $stmt->get_result();
$stmt->store_result();
$numrows = $stmt->num_rows;
$stmt->bind_result($entryID, $playerID, $supermail);
$stmt->fetch();

//echo $entryID . "<br>" . $playerID . "<br>" . $supermail;
//print_r($result_array);
//$result = $db->query($sql);
//print_r($ent);

//echo "entryID : " . $entryID;
//echo "<br>entryID: " . 
$stmt->free_result();
$stmt->close();
$db->close();

/*if (isset($entryID)) {
  $bytes = random_bytes(5);
  $code = bin2hex($bytes);
}*/
//print_r($numrows);
if ($numrows > 0) {
  //$result_array = mysqli_fetch_array($result);
  //print_r($result_array);
  //echo "<script>console.log(" . json_encode($result_array) . ");</script>";
  //print_r($result_array);
  //$entryID = $result_array[0];
  //$playerID = $result_array[1];

  $bytes = random_bytes(5);
  $code = bin2hex($bytes);
} else {
  //echo "0 results";
  die("Keine Einträge gefunden.");
}

if ($playerID != $userID) {
  echo "<br>Keine Berechtigung. PlayerID: " . $playerID . ", userID: " . $userID;
  die();
} else {
  //MySQL-Init
  $db = mysqli_connect($host, $user, $pass, $db_name) or die("Error.");
  $db->set_charset("utf8");
  if ($db->connect_error) {
      die("Connection failed: " . $db->connect_error);
  }

  //MySQL Select
  $stmt = $db->prepare("INSERT INTO checks (entryID, code) VALUES (?, ?)");
  $stmt->bind_param("is", $playID, $code);
  $stmt->execute() or die("error: <br>" . mysqli_error($db));
  //$result = $stmt->get_result(); // get the mysqli result
  //$result_array = $result->fetch_assoc(); // fetch data   
  //print_r($result);
  $db->close();

  $mailadress = $supermail;


  include("../mail/sendcheckcode.php");

  /*if($result == 1) {
    header("Location: ../index.php");
    die();
  }*/
  header("Location: ../loggedin.php?checked=" . $playID);
}
?>