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
  $result_array = mysqli_fetch_array($result);
}

$playerPlaytime;
$playerInstruments;
$generalPlaytime = 0;

foreach ($result as $row) {
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
    $playerInstruments[$row['username']] = $row['instrument'];
    $generalPlaytime += $row['playtime'];
}
arsort($playerPlaytime);

echo "<script>console.log(" . json_encode($playerPlaytime) . ");</script>";
echo "<script>console.log(" . json_encode($playerInstruments) . ");</script>";
echo "<script>console.log(" . json_encode($generalPlaytime) . ");</script>";

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
        <h5>Offizieller Übebeginn: 01. März 2021</h5>
        <!--<div class="fakeimg">Fake Image</div>-->
        <p align="justify">Willkommen bei der Übe-Challenge der Jugendorchesterschule Weimar-Apolda.
            Unsere Idee in dieser eher komplizierten Zeit für Musiker*innen ist ganz simpel: Da wir momentan noch nicht absehen können, ob im Sommer wieder ein Konzert mit großem Publikum zugelassen wird, wollen wir etwas Neues ausprobieren und planen am 18. Juli ein Konzert, das im Internet via Livestream angeschaut werden kann.
            Dafür haben wir die Weimarhalle gebucht und werden von SalveTV mit der nötigen Technik unterstützt. 
            Um das zu finanzieren, veranstalten wir eine Übe-Challenge, zu der wir euch herzlich einladen. Ihr könnt hier allein mit eurem Instrument das benötigte Geld erspielen und bereitet euch gleichzeitig auf den Konzerttag vor. Wie das genau funktioniert, ist unten erklärt. 
        </p>
        <br>
        <h2>Über das Projekt</h2>
        <h5>Alle Infos findet ihr hier!</h5>
        <!--<p><a href="https://github.com/Joni4Games/uebechallenge">https://github.com/Joni4Games/uebechallenge</a></p>-->
        <p align="justify">Auf dieser Seite könnt ihr die Übezeiten mit eurem Instrument eintragen und uns so helfen, unser Projekt im Sommer zu finanzieren. Das funktioniert eigentlich ganz einfach: 
            Um teilzunehmen registriert ihr euch mit einem selbstgewählten Benutzernamen, der nicht eurem Klarnamen entsprechen muss. Dieser Name kann dann von jedem auf dieser Seite eingesehen werden. Mit dem selbst gewählten Passwort könnt ihr euch dann jederzeit wieder auf der Webseite anmelden. Außerdem tragt ihr die E-Mail-Adresse einer dritten Person ein, z.B. die eurer Eltern. Die werden dann informiert, wenn ihr neue Übezeiten eintragt und können diese dann bestätigen.
        </p>
        <p align="justify">
            Für jede Stunde, die wir üben, erhalten wir von unseren Sponsoren 1€. Auf diese Weise erhöht sich der Große Balken, den ihr oben seht, immer weiter. Unser Ziel dabei ist es, auf 2500 € zu kommen, um die Konzertkosten zu decken.
        </p>
        <p align="justify">
            Zur Orientierung müssten also 50 Schüler bis zum 18. Juli je 50 Stunden üben. Das hört sich erstmal viel an, kann aber mit der richtigen Einteilung ohne Probleme geschafft werden. 
            Die Übe-Challenge startet am 1. März und bis zum 1. Mai könnt ihr euch anmelden. Eure Übezeiten könnt ihr bis zu unserem Konzert, also dem 18. Juli, eintragen.
            Auf der Seite findet ihr auch eine Übersicht derjenigen Schüler*innen, die aktuell am meisten geübt haben.
        </p>
        <p align="justify">
            Wie viel und wie oft ihr übt, bleibt natürlich euch überlassen. Es wäre schön, wenn ihr uns trotzdem tatkräftig unterstützt. Die Übe-Challenge ist dafür gedacht, dass ihr die Konzertstücke vorbereiten könnt, dabei Spaß habt und wir gleichzeitig das Geld für unser Konzert zusammenbekommen. 
            Zu Ende der Challenge werden wieder Preise verlost, es lohnt sich also mitzumachen. 
        </p>
        <p>
            Wir freuen uns auf eure kräftige Unterstützung. ;)
        </p>
        <p>Teilnehmerzahl: <b><?php echo $memberCount; ?></b></p>
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