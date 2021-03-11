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
if (isset($_POST['forename'])) { //forename
    $forename=mysqli_real_escape_string($db, $_POST['forename']);
}
if (isset($_POST['lastname'])) { //lastname
    $lastname=mysqli_real_escape_string($db, $_POST['lastname']);
}
if (isset($_POST['nickname'])) { //nickname
    $nickname=mysqli_real_escape_string($db, $_POST['nickname']);
}
if (isset($_POST['password'])) { //password
    $password=mysqli_real_escape_string($db, $_POST['password']);
}
if (isset($_POST['password2'])) { //password2
    $password2=mysqli_real_escape_string($db, $_POST['password2']);
}
if (isset($_POST['date'])) { //date
    $date=mysqli_real_escape_string($db, $_POST['date']);
}

$gender = (int)$_POST['gender'];
$instrument = (int)$_POST['instrument'];

if (isset($_POST['mail1a'])) { //mail1a
    $mail1a=mysqli_real_escape_string($db, $_POST['mail1a']);
}
if (isset($_POST['mail1b'])) { //mail1b
    $mail1b=mysqli_real_escape_string($db, $_POST['mail1b']);
}
if (isset($_POST['mail2a'])) { //mail2a
    $mail2a=mysqli_real_escape_string($db, $_POST['mail2a']);
}
if (isset($_POST['mail2b'])) { //mail2b
    $mail2b=mysqli_real_escape_string($db, $_POST['mail2b']);
}

$mail1 = trim($mail1a) . "@" . trim($mail1b);
$mail2 = trim($mail2a) . "@" . trim($mail2b);


if (strcmp($password, $password2) !== 0) {
    //die("Passwörter stimmen nicht überein.");
    //$db->close();
    header("Location: ../register.php?wrong=passwords&forename=" . $forename . "&lastname=" . $lastname . "&nickname=" . $nickname . "&date=" . $date . "&mail2a=" . $mail2a . "&mail2b=" . $mail2b . "&gender=" . $gender . "&instrument=" . $instrument);
    die();
}

$hashed_password = password_hash($password, PASSWORD_BCRYPT);
$hashed_password2 = password_hash($password2, PASSWORD_BCRYPT);

//print "<br>" . $hashed_password;
//print "<br>" . $hashed_password2;

//MySQL Select
$sql = 'SELECT * FROM participants WHERE mail = "' . $mail1 . '" OR username = "' . $nickname . '";';
$result = $db->query($sql);
$db->close();

if ($result->num_rows > 0) {
    //Mail bereits vergeben
    //print "<br>" . "Mail bereits vergeben.";
    header("Location: ../register.php?wrong=true&forename=" . $forename . "&lastname=" . $lastname . "&nickname=" . $nickname . "&date=" . $date . "&mail2a=" . $mail2a . "&mail2b=" . $mail2b . "&gender=" . $gender . "&instrument=" . $instrument);
    die();
} else {
    //Alles tip top
    //MySQL Insert
    //MySQL-Init
    $db = mysqli_connect($host, $user, $pass, $db_name) or die("Error.");
    $db->set_charset("utf8");
    if ($db->connect_error) {
        die("Connection failed: " . $db->connect_error);
    }
    $stmt = $db->prepare("INSERT INTO participants (username, forename, lastname, gender, birthdate, mail, password, supermail, instrument) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssissssi", $nickname, $forename, $lastname, $gender, $date, $mail1, $hashed_password, $mail2, $instrument);

    $stmt->execute() or die("<br>" . mysqli_error($db));

    $maxID = $stmt->insert_id;
    //print($maxID);
    header("Location: ../index.php?registered=true&mail=" . $mail1);
    $stmt->close();
    $db->close();
}
?>