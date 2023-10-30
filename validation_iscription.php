<?php
require('database.php');
require('user.php');
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_SESSION["email"];
    $password = $_SESSION["password"];
    $nom = $_POST["nom"];
    $prenom = $_POST["prenom"];
    $telephone = $_POST["tel"];
    $datejour = Date('Y-m-d H:i:s');

    $user = new User($nom, $prenom, $telephone, $email, $password, $datejour);
    $user->inscription($pdo);
}
