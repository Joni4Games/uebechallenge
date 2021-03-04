<?php
include_once "mysql.php";
//print_r($_POST);

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

/*if ($result->num_rows > 0) {
  $result_array = mysqli_fetch_array($result);
  //echo "<script>console.log(" . json_encode($result_array) . ");</script>";
  //print_r($result_array);
  $checkID = $result_array[1];
} else {
  //echo "0 results";
  die("Keine Einträge gefunden.");
}*/

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

echo "<html><body>";
echo "<p>Die Übezeit wurde überprüft.<br>Du kannst dieses Fenster nun schließen.</p>";
echo "</body></html>";


if($result == 1) {
  header("Location: ../index.php");
  die();
}

?>