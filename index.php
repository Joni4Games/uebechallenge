<?php
session_start();
if (isset($_SESSION["userID"]))
{
    header("Location: loggedin.php");
    die();
}

include_once "actions/mysql.php";

//MySQL-Init
$db = mysqli_connect($host, $user, $pass, $db_name) or die("Error.");
$db->set_charset("utf8");
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

//MySQL Select
$sql = 'SELECT entries.*, participants.* FROM entries INNER JOIN participants ON participants.ID=entries.playerID';
$result = $db->query($sql);

if ($result->num_rows > 0) {
  // output data of each row
  /*while($row = $result->fetch_assoc()) {
    echo "mail: " . $row["mail"];
    echo " password: " . $row["password"];
    echo "<br>";
  }*/
  $result_array = mysqli_fetch_array($result);

  //echo "<br>";
} else {
  //echo "0 results";
}

//print_r($result_array);
//print($result->num_rows);

$playerPlaytime;

foreach ($result as $row) {
    $playerPlaytime[$row['playerID']] = 0;
    $totalPlayTime = 0;
    $totalPlayTime = $totalPlayTime + $row['playtime'];
    $playerPlaytime[$row['playerID']] = $playerPlaytime[$row['playerID']] + $row['playtime'];
}

print_r($playerPlaytime);

$memberCount = $result->num_rows;

$db->close();
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
        <h1>Übechallenge des Jugendsinfonieorchesters Weimar</h1>
        <p>Herzlich Willkommen!</p> 
    </div>
    <div class="container">
        <h2>Fortschritt</h2>
        <div class="progress" style="height: 3em;">
            <div class="progress-bar progress-bar-striped progress-bar-animated bg-success" style="width:5%; font-size: x-large;">0€</div>
        </div>
    </div>

    <div class="container" style="margin-top:30px;">
    <div class="row">
        <div class="col-md-4">
            <div class="container" style="padding:0%;">
                <h2>Registrieren</h2>
                <h5></h5>
                <a href="register.php" role="button" class="btn btn-primary btn-block">Registrieren</a>
            </div>
            <div class="container" style="padding:0%; margin-top: 1em;">
                <h3>Login</h3>
                    <form action="actions/login.php" method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <input type="email" class="form-control" id="mail" placeholder="E-Mail" name="mail" <?php if (isset($_GET['mail'])){ echo 'value="'; echo $_GET['mail']; echo '"'; } ?> required>
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" id="password" placeholder="Passwort" name="password" required>
                        </div>
                        <?php
                        if (isset($_GET["wrong"]))
                        {
                            echo "<div class='alert alert-danger'>
                                <strong>Achtung!</strong> E-Mail und/oder Passwort sind falsch.
                            </div>";
                        }
                        ?>
                        <div class="form-group form-check">
                            <label class="form-check-label">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember" disabled> Erinnere mich
                            </label>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Einloggen</button>
                        <a href="#" class="btn btn-link btn-block" role="button">Passwort vergessen?</a>
                    </form>
            </div>
        <hr class="d-sm-none">
        </div>
        <div class="col-md-8">
        <h2>Übebeginn</h2>
        <h5>Offizieller Übebeginn, 01. Januar 2020</h5>
        <div class="fakeimg">Fake Image</div>
        <p>Some text..</p>
        <p>Sunt in culpa qui officia deserunt mollit anim id est laborum consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco.</p>
        <br>
        <h2>Über das Projekt</h2>
        <h5>Title description, Sep 2, 2017</h5>
        <div class="fakeimg">Fake Image</div>
        <p>Some text..</p>
        <p>Sunt in culpa qui officia deserunt mollit anim id est laborum consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco.</p>
        <!--<table class="table table-hover">
            <thead> 
                <tr>
                    <th>Benutzername</th>
                    <th>Übezeit gesamt</th>
                    <th>Übezeit in der letzten Woche</th>
                </tr>
            </thead>
            <tbody>
                    <tr>
                        <td>
                            <?php echo $memberCount; ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <?php echo $memberCount; ?>
                        </td>
                    </tr>
                <?php
                    foreach ($result as $row) {
                        $totalPlayTime = $totalPlayTime + $row['playtime'];
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
        </table>-->
        </div>
    </div>
    </div>
</body>
</html>