<?php $systeme_exploitation = PHP_OS;

if (strpos($systeme_exploitation, 'Darwin') !== false) {
    if (!isset($_SESSION["passwordBdd"], $_SESSION["hostBdd"])) {
        $passwordBdd = "root";
        $host = "127.0.0.1";
    }
} elseif (strpos($systeme_exploitation, 'WIN') !== false) {
    if (!isset($_SESSION["passwordBdd"], $_SESSION["hostBdd"])) {
        $passwordBdd = "";
        $host = "localhost";
    }
}




$bdd = new PDO(
    "mysql:host=$host;dbname=blablaomnes;charset=utf8",
    'root',
    $passwordBdd
);
