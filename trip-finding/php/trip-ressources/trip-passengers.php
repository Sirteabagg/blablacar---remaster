<?php
session_start();
$host = $_SESSION["hostBdd"];
$password = $_SESSION["passwordBdd"];


$bdd = new PDO(
    "mysql:host=$host;dbname=blablaomnes;charset=utf8",
    'root',
    $password
);

//$request = $bdd->query("SELECT ")
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

</body>

</html>