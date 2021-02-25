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
if (isset($_POST['mail1a'])) { //mail
  $mail1a=mysqli_real_escape_string($db, $_POST['mail1a']);
}
if (isset($_POST['mail1b'])) { //mail
  $mail1b=mysqli_real_escape_string($db, $_POST['mail1b']);
}

//Merge Mail Adress
$mail = $mail1a . "@" . $mail1b;

//MySQL Select
$sql = 'SELECT * FROM participants WHERE mail="' . $mail . '"';
$result = $db->query($sql);
//Close DB
$db->close();

if ($result->num_rows > 0) {
  //E-Mail in Datenbank gefunden
  $bytes = random_bytes(5);
  $code = bin2hex($bytes);
  //var_dump(bin2hex($bytes));

  //MySQL-Init
  $db = mysqli_connect($host, $user, $pass, $db_name) or die("Error.");
  $db->set_charset("utf8");
  if ($db->connect_error) {
      die("Connection failed: " . $db->connect_error);
  }

  $stmt = $db->prepare("INSERT INTO passwordreset (code, mail) VALUES (?, ?)");
  $stmt->bind_param("ss", $code, $mail);
  $stmt->execute() or die("<br>" . mysqli_error($db));

  $maxID = $stmt->insert_id;

  $stmt->close();
  $db->close();

  //Sende E-Mail mit Code
  

  header("Location: ../passwordreset.php?success=true");
  die();
} else {
  //E-Mail kommt in Datenbank nicht vor
  header("Location: ../passwordreset.php?success=false");
  die();
}

?>