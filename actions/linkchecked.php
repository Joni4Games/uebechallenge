<?php
include_once "mysql.php";
//print_r($_POST);

$success = false;
//GET-Variablen
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

//MySQL Select
$stmt = $db->prepare("SELECT entryID, ID FROM checks WHERE code=?");
//print_r($stmt);
$stmt->bind_param("s", $code);
$stmt->execute() or die("<br>" . mysqli_error($db));
//$result = $stmt->get_result();
$stmt->store_result();
$numrows = $stmt->num_rows;
$stmt->bind_result($checkID, $delID);
$stmt->fetch();
$stmt->free_result();
$stmt->close();
$db->close();

//print_r($numrows);
//print "delID: " . $delID;
//print "checkID: " . $checkID;

if ($result->num_rows <= 0) {
  //die("Keine Einträge gefunden.");
  $success = false;
} else {
  $success = true;
}

//MySQL-Init
$db = mysqli_connect($host, $user, $pass, $db_name) or die("Error.");
$db->set_charset("utf8");
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

//MySQL Select
$stmt = $db->prepare("UPDATE entries SET checked = 1 WHERE ID = ?");
//$stmt = $db->prepare("UPDATE participants SET password = ? WHERE participants.ID=?");
$stmt->bind_param("i", $checkID);
$stmt->execute() or die("error: <br>" . mysqli_error($db));
//$result = $stmt->get_result(); // get the mysqli result
//$result_array = $result->fetch_assoc(); // fetch data   
//print_r($result);
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

//MySQL Select
$stmt = $db->prepare("DELETE FROM checks WHERE entryID = ?");
$stmt->bind_param("i", $checkID);
$stmt->execute() or die("error: <br>" . mysqli_error($db));
//$result = $stmt->get_result(); // get the mysqli result
//$result_array = $result->fetch_assoc(); // fetch data   
//print_r($result);
$db->close();



if($result == 1) {
  header("Location: ../index.php");
  die();
}

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
        echo "<br>" . $success;
        ?>
        </p> 
    </div>
</body>
</html>