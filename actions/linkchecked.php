<?php
include_once "mysql.php";
$success = false;

//GET-Variablen in Variable gießen
if (isset($_GET['code'])) { //id
  $code=$_GET['code'];
}

//MySQL-Init
$db = mysqli_connect($host, $user, $pass, $db_name) or die("Error.");
$db->set_charset("utf8");
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}
$code=mysqli_real_escape_string($db, $code);

//MySQL-Select, Bind, Close
$stmt = $db->prepare("SELECT entryID, ID FROM checks WHERE code=?");
$stmt->bind_param("s", $code);
$stmt->execute() or die("<br>" . mysqli_error($db));
$stmt->store_result();
$numrows = $stmt->num_rows;
$stmt->bind_result($checkID, $delID);
$stmt->fetch();
$stmt->free_result();
$stmt->close();
$db->close();

//Zahl der Ergebnisse überprüfen
if ($numrows <= 0) {
  //Keine Einträge in Datenbank gefunden
  $success = false;
} else {
  //Einträge gefunden
  $success = true;

  //MySQL-Init
  $db = mysqli_connect($host, $user, $pass, $db_name) or die("Error.");
  $db->set_charset("utf8");
  if ($db->connect_error) {
      die("Connection failed: " . $db->connect_error);
  }

  //MySQL Select, Bild, Close
  $stmt = $db->prepare("UPDATE entries SET checked = 1 WHERE ID = ?");
  $stmt->bind_param("i", $checkID);
  $stmt->execute() or die("error: <br>" . mysqli_error($db));
  $stmt->fetch();
  $stmt->free_result();
  $stmt->close();
  $db->close();

  //MySQL-Init
  $db = mysqli_connect($host, $user, $pass, $db_name) or die("Error.");
  $db->set_charset("utf8");
  if ($db->connect_error) {
      die("Connection failed: " . $db->connect_error);
  }

  //MySQL Delete, Close
  $stmt = $db->prepare("DELETE FROM checks WHERE entryID = ?");
  $stmt->bind_param("i", $checkID);
  $stmt->execute() or die("error: <br>" . mysqli_error($db));
  $stmt->free_result();
  $stmt->close();
  $db->close();
}

/*if($result == 1) {
  header("Location: ../index.php");
  die();
}*/

?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Übechallange</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>
    <div class="jumbotron text-center">
        <h1>Übezeit bestätigen</h1>
        <p>
        <?php if ($success == true) {
          echo "Übezeit bestätigt.";
        } else {
          echo "Diese Zeit wurde bereits bestätigt.";
        }
        ?>
        </p> 
    </div>
</body>
</html>