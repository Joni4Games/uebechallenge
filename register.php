<?php
$wrong = false;
if (isset($_GET['wrong'])) {
    $wrong = true;
    $forename = $_GET['forename'];
    $lastname = $_GET['lastname'];
    $nickname = $_GET['nickname'];
    $date = $_GET['date'];
    $mail2a = $_GET['mail2a'];
    $mail2b = $_GET['mail2b'];
    $gender = $_GET['gender'];
    $instrument = $_GET['instrument'];
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
        <h1>Registrieren</h1>
        <p>Hier kannst du dich registrieren.</p> 
    </div>

    <div class="container" style="margin-top:30px;">
    <div class="row">
    <div class="col-sm-2"></div>
        <div class="col-sm-8">
            <div class="container" style="padding:0%;">
                <h2>Registrierung</h2>
                <div class="text-left grid" style="background-color: white; padding-top: 0px; margin-top: 0px;">
                <form action="actions/register.php" method="POST" enctype="multipart/form-data">
                    <!--Name-->
                    <div class="form-group mb-3">
                        <label for="title" class="mb-6 mr-sm-2">Name</label>
                        <input type="text" class="form-control mb-2 mr-sm-2" id="lastname" name="lastname" placeholder='Nachname' maxlength="20" <?php if ($wrong) {echo 'value="' . $lastname . '"';}?> required>
                    </div>
                    <!--Vorname-->
                    <div class="form-group mb-3">
                        <label for="title" class="mb-6 mr-sm-2">Vorname</label>
                        <input type="text" class="form-control mb-2 mr-sm-2" id="forename" name="forename" placeholder='Vorname' maxlength="20" <?php if ($wrong) {echo 'value="' . $forename . '"';}?> required>
                    </div>
                    <!--Benutzername-->
                    <div class="form-group mb-3">
                        <label for="title" class="mb-6 mr-sm-2">Benutzername</label>
                        <input type="text" class="form-control mb-2 mr-sm-2" id="nickname" name="nickname" placeholder='Benutzername' maxlength="20" <?php if ($wrong) {echo 'value="' . $nickname . '"';}?> required>
                    </div>
                    <!--Passwort-->
                    <div class="form-group mb-3">
                        <label for="title" class="mb-6 mr-sm-2">Passwort</label>
                        <input type="password" class="form-control mb-2 mr-sm-2" id="password" name="password" placeholder='Passwort' maxlength="20" required>
                    </div>
                    <!--Passwort wiederholen-->
                    <div class="form-group mb-3">
                        <label for="title" class="mb-6 mr-sm-2">Passwort wiederholen</label>
                        <input type="password" class="form-control mb-2 mr-sm-2" id="password2" name="password2" placeholder='Passwort' maxlength="20" required>
                    </div>
                    <!--Geburtsdatum-->
                    <div class="form-group mb-3">
                    <label for="date" class="mb-6 mr-sm-2">Geburtsdatum</label>
                        <input class="form-control" type="date" id="date" name="date" <?php if ($wrong) {echo 'value="' . $date . '"';} else {echo 'value="2001-01-01"';}?> required>
                    </div>
                    <!--Geschlecht-->
                    <div class="form-group mb-3">
                        <label for="text" class="mb-6 mr-sm-2">Geschlecht</label>
                        <select class="form-control" id="gender" name="gender" required>
                        <option value="0" <?php if ($wrong) { if ($gender == 0) {echo 'selected';}}?>>männlich</option>
                        <option value="1" <?php if ($wrong) { if ($gender == 1) {echo 'selected';}}?>>weiblich</option>
                        <option value="2" <?php if ($wrong) { if ($gender == 2) {echo 'selected';}}?>>divers</option>
                        </select>
                    </div>
                    <!--Instrument-->
                    <div class="form-group mb-3">
                        <label for="text" class="mb-6 mr-sm-2">Instrument</label>
                        <select class="form-control" id="instrument" name="instrument" required>
                        <option value="1" <?php if ($wrong) { if ($instrument == 1) {echo 'selected';}}?>>Violine</option>
                        <option value="2" <?php if ($wrong) { if ($instrument == 2) {echo 'selected';}}?>>Viola</option>
                        <option value="3" <?php if ($wrong) { if ($instrument == 3) {echo 'selected';}}?>>Violoncello</option>
                        <option value="4" <?php if ($wrong) { if ($instrument == 4) {echo 'selected';}}?>>Kontrabass</option>
                        <option value="5" <?php if ($wrong) { if ($instrument == 5) {echo 'selected';}}?>>Flöte</option>
                        <option value="6" <?php if ($wrong) { if ($instrument == 6) {echo 'selected';}}?>>Trompete</option>
                        <option value="7" <?php if ($wrong) { if ($instrument == 7) {echo 'selected';}}?>>Fagott</option>
                        <option value="8" <?php if ($wrong) { if ($instrument == 8) {echo 'selected';}}?>>Klarinette</option>
                        <option value="9" <?php if ($wrong) { if ($instrument == 9) {echo 'selected';}}?>>Oboe</option>
                        <option value="10" <?php if ($wrong) { if ($instrument == 10) {echo 'selected';}}?>>Posaune</option>
                        <option value="11" <?php if ($wrong) { if ($instrument == 11) {echo 'selected';}}?>>Horn</option>
                        <option value="12" <?php if ($wrong) { if ($instrument == 12) {echo 'selected';}}?>>Tuba</option>
                        <option value="13" <?php if ($wrong) { if ($instrument == 13) {echo 'selected';}}?>>Triangel</option>
                        <option value="14" <?php if ($wrong) { if ($instrument == 14) {echo 'selected';}}?>>Trommel</option>
                        <option value="15" <?php if ($wrong) { if ($instrument == 15) {echo 'selected';}}?>>Pauke</option>
                        <option value="16" <?php if ($wrong) { if ($instrument == 16) {echo 'selected';}}?>>Sonstige</option>
                        </select>
                    </div>
                    <!--E-Mail-->
                    <div class="form-group mb-3">
                        <label for="title" class="mb-6 mr-sm-2">E-Mail</label>
                        <div class="input-group mb-3">
                        <input type="text" class="form-control" id="mail1a" name="mail1a" placeholder="max" maxlength="50" required>
                        <div class="input-group-prepend input-group-append">
                                <span class="input-group-text">@</span>
                            </div>
                        <input type="text" class="form-control" id="mail1b" name="mail1b" placeholder="mustermann.de" maxlength="19" required>
                        </div>
                        <?php
                        if (isset($_GET["wrong"]))
                        {
                            echo "<div class='alert alert-danger'>
                                <strong>Achtung!</strong> Diese E-Mail-Adresse wird bereits verwendet.
                            </div>";
                        }
                        ?>
                    </div>
                    <!--E-Mail 2-->
                    <div class="form-group mb-3">
                        <label for="title" class="mb-6 mr-sm-2">E-Mail des Sorgeberechtigten</label>
                        <div class="input-group mb-3">
                        <input type="text" class="form-control" id="mail2a" name="mail2a" placeholder="max" maxlength="50" <?php if ($wrong) {echo 'value="' . $mail2a . '"';}?> required>
                        <div class="input-group-prepend input-group-append">
                                <span class="input-group-text">@</span>
                            </div>
                        <input type="text" class="form-control" id="mail2b" name="mail2b" placeholder="mustermann.de" maxlength="19" <?php if ($wrong) {echo 'value="' . $mail2b . '"';}?> required>
                        </div>
                    </div>
                    <p>
                        <button type="submit" class="btn btn-primary my-2" value="Submit">Registrieren</button>
                        <a href="index.php" class="btn btn-secondary my-2" value="Abbrechen">Abbrechen</a>
                    </p>
                </form>
            </div>
            </div>
        <hr class="d-sm-none">
        </div>
    </div>
    <div class="col-sm-2"></div>
    </div>
</body>
</html>