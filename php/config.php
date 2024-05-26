<?php
$systeme_exploitation = PHP_OS;

if (strpos($systeme_exploitation, 'Darwin') !== false) {
    $passwordBdd = "root";
    $host = "127.0.0.1";
} elseif (strpos($systeme_exploitation, 'WIN') !== false) {
    $passwordBdd = "";
    $host = "localhost";
}




$bdd = new PDO(
    "mysql:host=$host;dbname=blablaomnes;charset=utf8",
    'root',
    $passwordBdd
);
