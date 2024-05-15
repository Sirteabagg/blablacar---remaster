<?php
session_start();

$systeme_exploitation = PHP_OS;

if (strpos($systeme_exploitation, 'Darwin') !== false) {
    if (!isset($_SESSION["passwordBdd"], $_SESSION["hostBdd"])) {
        $_SESSION["passwordBdd"] = "root";
        $_SESSION["hostBdd"] = "127.0.0.1";
    }
} elseif (strpos($systeme_exploitation, 'WIN') !== false) {
    if (!isset($_SESSION["passwordBdd"], $_SESSION["hostBdd"])) {
        $_SESSION["passwordBdd"] = "";
        $_SESSION["hostBdd"] = "localhost";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form method="post" action="test-os.php">
        <input type="text" id>
    </form>
</body>

</html>

<a href="test-os2.php">proute</a>