<?php
if (isset($_GET['code'])) {
    $code = $_GET['code'];
} else {
    header("Location: index.php");
    die;
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
        <h1>Passwort</h1>
        <p>Hier kannst du dein neues Passwort eingeben.</p> 
    </div>

    <div class="container" style="margin-top:30px;">
    <div class="row">
    <div class="col-sm-2"></div>
        <div class="col-sm-8">
            <div class="container" style="padding:0%;">
                <h2>Passwort zurücksetzen</h2>
                <div class="text-left grid" style="background-color: white; padding-top: 0px; margin-top: 0px;">
                <form action="actions/setnewpassword.php" method="POST" enctype="multipart/form-data">
                    <!--Passwort-->
                    <div class="form-group mb-3">
                        <label for="title" class="mb-6 mr-sm-2">Passwort (mind. 6 Zeichen)</label>
                        <input type="password" class="form-control mb-2 mr-sm-2" id="password" name="password" placeholder='Passwort' maxlength="20" minlength="6" required>
                    </div>
                    <!--Passwort wiederholen-->
                    <div class="form-group mb-3">
                        <label for="title" class="mb-6 mr-sm-2">Passwort wiederholen</label>
                        <input type="password" class="form-control mb-2 mr-sm-2" id="password2" name="password2" placeholder='Passwort' maxlength="20" minlength="6" required>
                    </div>
                    <input type="hidden" id="code" name="code" value="<?php echo $code; ?>">
                    <p>
                        <button type="submit" class="btn btn-primary my-2" value="Submit">Zurücksetzen</button>
                        <a href="index.php" class="btn btn-secondary my-2" value="Abbrechen">Zurück</a>
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