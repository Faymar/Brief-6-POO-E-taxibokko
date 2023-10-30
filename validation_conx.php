<?php
require('database.php');
require('user.php');
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $password = $_POST['password'];
    $email = $_POST['email'];
    User::seConnecter($pdo, $email, $password);

    $pdo = null;
}
