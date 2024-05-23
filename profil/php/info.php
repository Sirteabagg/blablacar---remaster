<?php
session_start();

// Récupérer les informations de la session
$host = $_SESSION["hostBdd"];
$password = $_SESSION["passwordBdd"];
$email = $_SESSION["current-user-email"];

try {
    // Connexion à la base de données
    $bdd = new PDO(
        "mysql:host=$host;dbname=blablaomnes;charset=utf8",
        'root',
        $password
    );
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Si le formulaire est soumis, mettre à jour les informations utilisateur
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        $numerotel = $_POST['numerotel'];

        // Préparation de la requête de mise à jour
        $stmt = $bdd->prepare("UPDATE User SET nom = :nom, prenom = :prenom, numerotel = :numerotel WHERE email = :email");
        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':prenom', $prenom);
        $stmt->bindParam(':numerotel', $numerotel);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        // Rediriger vers la page profilform.php après la mise à jour
        header("Location: profilforme.php");
        exit(); // Assurez-vous de sortir pour éviter l'exécution ultérieure du script
    }

    // Préparation et exécution de la requête pour récupérer les informations utilisateur
    $stmt = $bdd->prepare("SELECT nom, prenom, email, numerotel FROM User WHERE email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    // Récupération des données utilisateur
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        throw new Exception("Utilisateur non trouvé");
    }
} catch (Exception $e) {
    die("Erreur : " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/style-main-structure.css">
    <link rel="stylesheet" href="../styles/style-info.css">
    <script src="../scripts/script-modif-info.js" defer></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <title>Mes Infos</title>
</head>

<body>
    <div class="container">
        <h1 class="titre">Mes Infos</h1>
        <form action="" method="post">
            <div class="grid">
                <div class="case">
                    <input type="text" placeholder="nom" name="nom" class="form-input" value="<?php echo htmlspecialchars($user['nom'] ?? ''); ?>">
                </div>
                <div class="case">
                    <input type="text" placeholder="prenom" name="prenom" class="form-input" value="<?php echo htmlspecialchars($user['prenom'] ?? ''); ?>">
                </div>
                <div class="case">
                    <input type="text" placeholder="email" name="email" class="form-input" value="<?php echo htmlspecialchars($user['email'] ?? ''); ?>" readonly>
                </div>
                <div class="case">
                    <input type="text" placeholder="numerotel" name="numerotel" class="form-input" value="<?php echo htmlspecialchars($user['numerotel'] ?? ''); ?>">
                </div>
                <input type="submit" class="button-submit" value="submit">
            </div>
        </form>
    </div>
</body>

</html>
