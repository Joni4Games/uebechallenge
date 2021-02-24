<?php
session_start();
if (empty($_SESSION["userID"]))
{
    header("Location: index.php");
    die();
} else {
    $userID = $_SESSION["userID"];
    include_once "actions/mysql.php";
}

//MySQL-Init
$db = mysqli_connect($host, $user, $pass, $db_name) or die("Error.");
$db->set_charset("utf8");
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

//MySQL Select
$sql = 'SELECT * FROM participants INNER JOIN instruments ON participants.instrument=instruments.ID WHERE participants.ID=' . $userID;
//print($sql);
$result = $db->query($sql);

if ($result->num_rows > 0) {
  // output data of each row
  /*while($row = $result->fetch_assoc()) {
    echo "mail: " . $row["mail"];
    echo " password: " . $row["password"];
    echo "<br>";
  }*/
  $result_array = mysqli_fetch_array($result);
  echo "<script>console.log(" . json_encode($result_array) . ");</script>";
  //print_r($result_array);
  $db_password = $result_array[2];
  $user_ID = $result_array[0];
  //echo "results: " . $result->num_rows;
  //echo "<br>";
} else {
  //echo "0 results";
}

$db->close();

//MySQL-Init 2
$db2 = mysqli_connect($host, $user, $pass, $db_name) or die("Error.");
$db2->set_charset("utf8");
if ($db2->connect_error) {
    die("Connection failed: " . $db2->connect_error);
}

//MySQL Select 2
$sql2 = 'SELECT * FROM entries WHERE playerID=' . $userID;

$result2 = $db2->query($sql2);
//print_r($result2);

if ($result2->num_rows > 0) {
  // output data of each row
  /*while($row = $result->fetch_assoc()) {
    echo "mail: " . $row["mail"];
    echo " password: " . $row["password"];
    echo "<br>";
  }*/
  $result_array2 = mysqli_fetch_array($result2);
  echo "<script>console.log(" . json_encode($result_array2) . ");</script>";
  //print_r($result_array);
  $db_password = $result_array[2];
  $user_ID = $result_array[0];
  //echo "results: " . $result->num_rows;
  //echo "<br>";
} else {
  //echo "0 results";
}

$db2->close();

$totalPlayTime = 0;
foreach ($result2 as $row) {
    $totalPlayTime = $totalPlayTime + $row['playtime'];
}
?>

<!DOCTYPE html>
<html lang="en">
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
        <h1>Deine Übezeiten</h1>
        <p>Herzlich Willkommen!</p> 
    </div>
    <div class="container">
        <h2>Dein Fortschritt</h2>
        <div class="progress" style="height: 3em;">
            <div class="progress-bar progress-bar-striped progress-bar-animated" style="width:<?php echo $totalPlayTime / 960 * 100; ?>%"></div>
        </div>
        <h4 style="text-align: center; margin-top: 0.5em;"><?php echo $totalPlayTime; ?> Minuten - <?php echo round($totalPlayTime / 60, 2); ?> € - <?php echo round($totalPlayTime / 960 * 100, 1);?>%</h4>
    </div>

    <div class="container" style="margin-top:30px;">
    <div class="row">
        <div class="col-md-4">
            <div class="container" style="padding:0%;">
                <h2>Dein Übeprofil</h2>
                <p>Hallo, <?php echo $result_array[2]; ?>! Du bist eingeloggt.<br>
                <b>Dein Benutzername:</b> <?php echo $result_array[1]; ?><br>
                <b>Deine E-Mail:</b> <?php echo $result_array[6]; ?><br>
                <b>Deine Prüfmail:</b> <?php echo $result_array[8]; ?><br>
                <b>Dein Instrument:</b> <?php echo $result_array[11]; ?></p>
                <a href="actions/logout.php" role="button" class="btn btn-danger btn-block">Ausloggen</a>
            </div>
        <hr class="d-md-none">
        </div>
        <div class="col-md-8">
        <h2>Deine Übestatistik</h2>
        <h5>Deine Übezeiten im Überblick.</h5>
        <table class="table table-hover">
            <thead> 
                <tr>
                    <th>Datum</th>
                    <th>Übezeit</th>
                    <th>Bestätigt</th>
                    <th>Aktion</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    foreach ($result2 as $row) {
                        echo "<tr>";
                        echo "<td>";
                        echo date_format(date_create($row['weekNumber']), "d.m.Y");
                        echo "</td>";
                        echo "<td>";
                        echo $row['playtime'] . " Minuten";
                        echo "</td>";
                        echo "<td>";
                        if ($row['checked']) {
                            echo "&check;";
                        } else {
                            echo "&cross;";
                        }
                        //echo $row['checked'];
                        echo "</td>";
                        echo "<td>";
                        echo '<a href="actions/deleteplaytime.php?id=' . $row['ID'] . '" class="btn btn-danger btn-block">Löschen</a>';
                        echo "</td>";
                        echo "</tr>";
                    }
                ?>
            </tbody>
        </table>
        <p>Als Ziel sind 16 Stunden pro Person gesetzt.</p>
        <p>Sunt in culpa qui officia deserunt mollit anim id est laborum consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco.</p>
        <br>
        <h2>Übezeit eintragen</h2>
        <h5>Hier kannst du deine Übezeit eintragen.</h5>
            <form action="actions/addplaytime.php" method="POST" enctype="multipart/form-data">
                <div class="form-group row">
                    <!--<label for="weeknumber" class="col-3 col-form-label">Nummer der Woche</label>
                    <div class="col-2">
                        <input class="form-control" type="number" value="1" id="weeknumber" name="weeknumber" min="1">
                    </div>-->
                    <label for="weeknumber" class="col-2 col-form-label">Datum</label>
                    <div class="col-3">
                        <input class="form-control" type="date" value="2020-03-01" id="weeknumber" id="weeknumber" name="weeknumber">
                    </div>
                    <label for="hours" class="col-4 col-form-label">Anzahl der geübten Minuten</label>
                    <div class="col-2">
                        <input class="form-control" type="number" value="15" id="hours" name="hours" min="1">
                    </div>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Eintragen</button>
                <a href="loggedin.php" class="btn btn-link btn-block" role="button">Zurücksetzen</a>
            </form>
        <p>Some text..</p>
        <p>Sunt in culpa qui officia deserunt mollit anim id est laborum consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco.</p>
        </div>
    </div>
    </div>
</body>
</html>