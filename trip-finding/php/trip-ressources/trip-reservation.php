<?php
session_start();

$host = $_SESSION["hostBdd"];
$password = $_SESSION["passwordBdd"];


$bdd = new PDO(
    "mysql:host=$host;dbname=blablaomnes;charset=utf8",
    'root',
    $password
);

echo $_GET["idpassenger"];
echo $_GET["idTrip"];
