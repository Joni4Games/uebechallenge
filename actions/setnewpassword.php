<?php
if (empty($_POST))
{
    header("Location: index.php");
    die();
}

include_once "mysql.php";

//MySQL-Init
$db = mysqli_connect($host, $user, $pass, $db_name) or die("Error.");
$db->set_charset("utf8");
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

//POST-Variablen
if (isset($_POST['password'])) { //mail
  $password=mysqli_real_escape_string($db, $_POST['password']);
}
if (isset($_POST['password2'])) { //mail
  $password2=mysqli_real_escape_string($db, $_POST['password2']);
}

//Merge Mail Adress
if (strcmp($password, $password2) !== 0) {
  die("Passwörter stimmen nicht überein.");
  $db->close();
}

$hashed_password = password_hash($password, PASSWORD_BCRYPT);
$hashed_password2 = password_hash($password2, PASSWORD_BCRYPT);

$code = $_POST['code'];

//MySQL Select
$sql = 'SELECT participants.ID FROM participants INNER JOIN passwordreset ON passwordreset.participantID=participants.ID WHERE passwordreset.code="' . $code . '"';

$result = $db->query($sql);
$result_array = mysqli_fetch_array($result);

//Close DB
$db->close();

if ($result->num_rows > 0) {
  $ID = $result_array[0];
  //E-Mail in Datenbank gefunden
  $bytes = random_bytes(5);
  $code = bin2hex($bytes);
  $ccode = $code;
  //var_dump(bin2hex($bytes));

  //MySQL-Init
  $db = mysqli_connect($host, $user, $pass, $db_name) or die("Error.");
  $db->set_charset("utf8");
  if ($db->connect_error) {
      die("Connection failed: " . $db->connect_error);
  }

  $stmt = $db->prepare("UPDATE participants SET password = ? WHERE participants.ID=?");
  $stmt->bind_param("si", $hashed_password, $ID);
  $stmt->execute() or die("<br>" . mysqli_error($db));

  $maxID = $stmt->insert_id;

  $stmt->close();
  $db->close();

  //MySQL-Init
  $db = mysqli_connect($host, $user, $pass, $db_name) or die("Error.");
  $db->set_charset("utf8");
  if ($db->connect_error) {
      die("Connection failed: " . $db->connect_error);
  }

  $stmt = $db->prepare("DELETE FROM passwordreset WHERE participantID=?");
  $stmt->bind_param("i", $ID);
  $stmt->execute() or die("<br>" . mysqli_error($db));

  $maxID = $stmt->insert_id;

  $stmt->close();
  $db->close();

  

  header("Location: ../index.php?registered=true");
  die();
} else {
  //E-Mail kommt in Datenbank nicht vor
  header("Location: ../index.php?wrong=true");
  die();
}

?>