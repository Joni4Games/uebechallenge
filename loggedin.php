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

//MySQL Select, Bind, Close
$stmt = $db->prepare('SELECT * FROM participants INNER JOIN instruments ON participants.instrument=instruments.ID WHERE participants.ID=?');
$stmt->bind_param("i", $userID);
$stmt->execute() or die("<br>" . mysqli_error($db));
$stmt->store_result();
$numrows = $stmt->num_rows;
$stmt->bind_result($user_ID, $user_name, $user_forename, $user_lastname, $user_gender, $user_birthdate, $user_mail, $user_password, $user_supermail, $user_instrument, $user_registerDate, $user_instrumentID, $user_instrumentName, $user_instrumentType);
$stmt->fetch();
$stmt->free_result();
$stmt->close();
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
  //$db_password = $result_array[2];
  //$user_ID = $result_array[0];
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
                <p>Hallo, <?php echo $user_forename; ?>! Du bist eingeloggt.<br>
                <b>Dein Benutzername:</b> <?php echo $user_name; ?><br>
                <b>Deine E-Mail:</b> <?php echo $user_mail; ?><br>
                <b>Deine Prüfmail:</b> <?php echo $user_supermail; ?><br>
                <b>Dein Instrument:</b> <?php echo $user_instrumentName; ?></p>
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
                            if(isset($_GET['checked']) && $_GET['checked'] == $row['ID']) {
                                echo '&#128337;';
                            } else {
                                echo '<a href="actions/setchecked.php?id=' . $row['ID'] . '&time=' . $row['playtime'] . '" class="btn btn-success btn-block">E-Mail</a>';
                            }
                            //echo "&cross;";
                            
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
        <hr class="d-md">
        <div id="accordion">
            <div class="card">
                <div class="card-header">
                <a class="card-link" data-toggle="collapse" href="#collapseOne">
                    Übezeit eintragen
                </a>
                </div>
                <div id="collapseOne" class="collapse" data-parent="#accordion">
                <div class="card-body">
                <h2>Übezeit eintragen</h2>
                    <h5>Hier kannst du deine Übezeit eintragen.</h5>
                        <form action="actions/addplaytime.php" method="POST" enctype="multipart/form-data">
                            <div class="form-group row">
                                <!--<label for="weeknumber" class="col-3 col-form-label">Nummer der Woche</label>
                                <div class="col-2">
                                    <input class="form-control" type="number" value="1" id="weeknumber" name="weeknumber" min="1">
                                </div>-->
                                <label for="weeknumber" class="col col-form-label">Datum</label>
                                <div class="col-lg">
                                    <input class="form-control" type="date" value="2021-03-01" id="weeknumber" id="weeknumber" name="weeknumber">
                                </div>
                                <label for="hours" class="col col-form-label">geübte Minuten</label>
                                <div class="col-lg">
                                    <input class="form-control" type="number" value="15" id="hours" name="hours" min="1">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Eintragen</button>
                            <!--<a href="loggedin.php" class="btn btn-link btn-block" role="button">Zurücksetzen</a>-->
                        </form>
                </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                <a class="collapsed card-link" data-toggle="collapse" href="#collapseTwo">
                    FAQ
                </a>
                </div>
                <div id="collapseTwo" class="collapse" data-parent="#accordion">
                <div class="card-body">
                <h2>FAQ</h2>
                <p><b>Wie viele Stunden sollte ich üben?</b><br>Als Ziel sind 16 Stunden pro Person gesetzt.</p>
                <p><b>Wie funktioniert das Bestätigen?</b><br>Jede Übezeit muss bestätigt werden. Klicke dazu einfach auf den "E-Mail"-Button und lass deine Eintragung über das E-Mail-Postfach der Prüfmail bestätigen.</p>
                <p><b>Kann ich meine Daten ändern lassen?</b><br>Ja! Dein Passwort kannst Du auf der Startseite über die "Passwort vergessen"-Funktion ändern lassen. Für alle anderen Änderungen, schicke bitte eine E-Mail an support@jugendorchesterschule.de</p>
                </div>
                </div>
            </div>
            <br><br>

            <!--<div class="card">
                <div class="card-header">
                <a class="collapsed card-link" data-toggle="collapse" href="#collapseThree">
                    Collapsible Group Item #3
                </a>
                </div>
                <div id="collapseThree" class="collapse" data-parent="#accordion">
                <div class="card-body">
                    Lorem ipsum..
                </div>
                </div>
            </div>-->
            </div>
        </div>
    </div>
</div>
</body>
</html>