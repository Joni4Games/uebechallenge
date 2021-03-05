<?php
session_start();
if (empty($_GET))
{
  echo "GET empty";
}
if (empty($_SESSION["userID"]))
{
  echo "SESSION empty";
} else {
  $userID = $_SESSION["userID"];
}
if (empty($_SESSION["mail"]))
{
  echo "SESSION empty";
  print_r($_SESSION);
} else {
  $mailadress = $_SESSION["mail"];
}

include_once "mysql.php";

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

//MySQL Select, Bind, Close
$stmt = $db->prepare('SELECT entries.ID, playerID, supermail FROM entries INNER JOIN participants ON entries.playerID=participants.ID WHERE entries.ID=?');
$stmt->bind_param("i", $playID);
$stmt->execute() or die("<br>" . mysqli_error($db));
$stmt->store_result();
$numrows = $stmt->num_rows;
$stmt->bind_result($entryID, $playerID, $supermail);
$stmt->fetch();
$stmt->free_result();
$stmt->close();
$db->close();

if ($numrows > 0) {
  $bytes = random_bytes(5);
  $code = bin2hex($bytes);
} else {
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

  //MySQL Select, Close
  $stmt = $db->prepare("INSERT INTO checks (entryID, code) VALUES (?, ?)");
  $stmt->bind_param("is", $playID, $code);
  $stmt->execute() or die("error: <br>" . mysqli_error($db));
  $db->close();

  $mailadress = $supermail;
  include("../mail/sendcheckcode.php");
  header("Location: ../loggedin.php?checked=" . $playID);
}
?>