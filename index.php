<?php
session_start();
if (isset($_SESSION["userID"]))
{
    header("Location: loggedin.php");
    die();
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
    <div class="jumbotron text-center head">
        <h1>Übechallenge des Jugendsinfonieorchesters Weimar</h1>
        <p>Herzlich Willkommen!</p> 
    </div>
    <div class="container">
        <h2>Fortschritt</h2>
        <div class="progress" style="height: 2em;">
            <div class="progress-bar progress-bar-striped progress-bar-animated" style="width:40%"></div>
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
        </div>
    </div>
    </div>
</body>
</html>