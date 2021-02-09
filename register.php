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
                        <input type="text" class="form-control mb-2 mr-sm-2" id="lastname" name="lastname" placeholder='Nachname' required>
                    </div>
                    <!--Vorname-->
                    <div class="form-group mb-3">
                        <label for="title" class="mb-6 mr-sm-2">Vorname</label>
                        <input type="text" class="form-control mb-2 mr-sm-2" id="forename" name="forename" placeholder='Vorname' required>
                    </div>
                    <!--Benutzername-->
                    <div class="form-group mb-3">
                        <label for="title" class="mb-6 mr-sm-2">Benutzername</label>
                        <input type="text" class="form-control mb-2 mr-sm-2" id="nickname" name="nickname" placeholder='Benutzername' required>
                    </div>
                    <!--Passwort-->
                    <div class="form-group mb-3">
                        <label for="title" class="mb-6 mr-sm-2">Passwort</label>
                        <input type="password" class="form-control mb-2 mr-sm-2" id="password" name="password" placeholder='Passwort' required>
                    </div>
                    <!--Passwort wiederholen-->
                    <div class="form-group mb-3">
                        <label for="title" class="mb-6 mr-sm-2">Passwort wiederholen</label>
                        <input type="password" class="form-control mb-2 mr-sm-2" id="password2" name="password2" placeholder='Passwort' required>
                    </div>
                    <!--Geburtsdatum-->
                    <div class="form-group mb-3">
                    <label for="date" class="mb-6 mr-sm-2">Geburtsdatum</label>
                        <input class="form-control" type="date" value="2001-01-01" id="date" name="date" required>
                    </div>
                    <!--Geschlecht-->
                    <div class="form-group mb-3">
                        <label for="text" class="mb-6 mr-sm-2">Geschlecht</label>
                        <select class="form-control" id="gender" name="gender" required>
                        <option>männlich</option>
                        <option>weiblich</option>
                        <option>divers</option>
                        </select>
                    </div>
                    <!--Instrument-->
                    <div class="form-group mb-3">
                        <label for="text" class="mb-6 mr-sm-2">Instrument</label>
                        <select class="form-control" id="instrument" name="instrument" required>
                        <option>1. Geige</option>
                        <option>2. Geige</option>
                        <option>Bratsche</option>
                        <option>Cello</option>
                        <option>Kontrabass</option>
                        <option>Horn</option>
                        <option>...</option>
                        </select>
                    </div>
                    <!--E-Mail-->
                    <div class="form-group mb-3">
                        <label for="title" class="mb-6 mr-sm-2">E-Mail</label>
                        <div class="input-group mb-3">
                        <input type="text" class="form-control" id="mail1a" name="mail1a" placeholder="max" required>
                        <div class="input-group-prepend input-group-append">
                                <span class="input-group-text">@</span>
                            </div>
                        <input type="text" class="form-control" id="mail1b" name="mail1b" placeholder="mustermann.de" required>
                        </div>
                    </div>
                    <!--E-Mail 2-->
                    <div class="form-group mb-3">
                        <label for="title" class="mb-6 mr-sm-2">E-Mail des Sorgeberechtigten</label>
                        <div class="input-group mb-3">
                        <input type="text" class="form-control" id="mail2a" name="mail2a" placeholder="max" required>
                        <div class="input-group-prepend input-group-append">
                                <span class="input-group-text">@</span>
                            </div>
                        <input type="text" class="form-control" id="mail2b" name="mail2b" placeholder="mustermann.de" required>
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