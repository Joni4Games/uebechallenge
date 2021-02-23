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
$sql = 'SELECT entries.playerID, entries.playtime, participants.ID, participants.username, instruments.name AS instrument FROM entries INNER JOIN participants ON participants.ID=entries.playerID INNER JOIN instruments on participants.instrument=instruments.ID';
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
$playerInstruments;

//print_r($result);
$generalPlaytime = 0;
foreach ($result as $row) {
    //$playerPlaytime[$row['username']] = 0;
    if (isset($totalPlayTime)) {
        $totalPlayTime = $totalPlayTime + $row['playtime'];
    } else {
        $totalPlayTime = $row['playtime'];
    }
    
    if (isset($playerPlaytime[$row['username']])) {
        $playerPlaytime[$row['username']] = $playerPlaytime[$row['username']] + $row['playtime'];
    } else {
        $playerPlaytime[$row['username']] = (int)$row['playtime'];
    }
    //print_r($row['instrument']);
    
    //print_r($playerPlaytime);
    //print($totalPlayTime);
    $playerInstruments[$row['username']] = $row['instrument'];
    $generalPlaytime += $row['playtime'];
}
arsort($playerPlaytime);

echo "<script>console.log(" . json_encode($playerPlaytime) . ");</script>";
echo "<script>console.log(" . json_encode($playerInstruments) . ");</script>";
echo "<script>console.log(" . json_encode($generalPlaytime) . ");</script>";

//$memberCount = $result->num_rows;
$memberCount = count($playerInstruments);

$db->close();
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
        <h1>Übechallenge der Jugendorchesterschule</h1>
        <p>Herzlich Willkommen!</p> 
    </div>
    <div class="container">
        <h2>Fortschritt</h2>
        <div class="progress" style="height: 3em;">
            <div class="progress-bar progress-bar-striped progress-bar-animated bg-success" style="width:<?php echo $generalPlaytime / 60 * 0.03882; ?>%; font-size: x-large;"></div>
        </div>
        <h4 style="text-align: center; margin-top: 0.5em;"><?php echo $generalPlaytime; ?> Minuten - <?php echo round($generalPlaytime / 60, 2); ?> € - <?php echo round($generalPlaytime / 60 * 0.03882, 2); ?>%</h4>
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
                        if (isset($_GET["registered"]))
                        {
                            echo "<div class='alert alert-success'>
                                <strong>Sehr gut!</strong> Du kannst Dich jetzt anmelden.
                            </div>";
                        }
                        ?>
                        <div class="form-group form-check">
                            <label class="form-check-label">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember" disabled> Erinnere mich
                            </label>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Einloggen</button>
                        <a href="passwordreset.php" class="btn btn-link btn-block" role="button">Passwort vergessen?</a>
                    </form>
            </div>
        <hr class="d-sm-none">
        </div>
        <div class="col-md-8">
        <h2>Übebeginn</h2>
        <h5>Offizieller Übebeginn, 01. März 2021</h5>
        <div class="fakeimg">Fake Image</div>
        <p>Some text..</p>
        <p>Sunt in culpa qui officia deserunt mollit anim id est laborum consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco.</p>
        <br>
        <h2>Über das Projekt</h2>
        <h5>Title description, Sep 2, 2017</h5>
        <div class="fakeimg">Fake Image</div>
        <p>Some text..</p>
        <p>Sunt in culpa qui officia deserunt mollit anim id est laborum consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco.</p>
        <p>Teilnehmerzahl: <?php echo $memberCount; ?></p>
        <table class="table table-hover">
            <thead> 
                <tr>
                    <th>Benutzername</th>
                    <th>Übezeit gesamt</th>
                    <th>Instrument</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    /*foreach ($result as $row) {
                        $playerPlaytime[$row['username']] = 0;
                        $totalPlayTime = 0;
                        $totalPlayTime = $totalPlayTime + $row['playtime'];
                        $playerPlaytime[$row['username']] = $playerPlaytime[$row['username']] + $row['playtime'];
                    }*/

                    foreach ($playerPlaytime as $username => $minutes) {
                        echo "<tr>";
                        echo "<td>";
                        echo $username;
                        echo "</td>";
                        echo "<td>";
                        echo $minutes . " Minuten";
                        echo "</td>";
                        echo "<td>";
                        echo $playerInstruments["$username"];
                        echo "</td>";
                        echo "</tr>";
                    }
                ?>
            </tbody>
        </table>
        </div>
    </div>
    </div>
</body>
</html>