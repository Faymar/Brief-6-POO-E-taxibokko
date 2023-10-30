<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $_SESSION["email"] = $_POST["email"];
    $_SESSION["password"] = $_POST["password"];
?>
    <html lang="fr">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="style.css">
        <title>connexion</title>
    </head>

    <body>
        <div class="box_login">
            <div class="box_form">
                <h1>Bienvenue</h1>
                <p>Finaliser votre inscription en renseignant les informations manquantes</p><br>

                <form action="validation_iscription.php" method="post">
                    <div class="groupe">
                        <label for=""><b>PRENOM</b></label>
                        <label for=""><b>NOM</b></label>
                        <input type="text" placeholder="votre Prenom" name="prenom" required />
                        <input type="text" placeholder="votre nom" name="nom" required />
                    </div>
                    <div class="simple">
                        <label for=""><b>TELEPHONE</b></label>
                        <div class="groupeTel">
                            <div class="indicatif">+221</div>
                            <input type="number" class="numero" name="tel" placeholder="Votre numéro de téléphone" required>
                        </div>
                    </div>
                    <div class="input_box">
                        <button class="button2">S"inscrire</button>
                    </div>
                </form>
            </div>
        </div>
    </body>

    </html>
<?php
}
?>