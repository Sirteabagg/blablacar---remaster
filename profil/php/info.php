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

    // Si le formulaire pour la mise à jour des informations utilisateur est soumis
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_user_info'])) {
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        $numerotel = $_POST['numerotel'];

        // Préparation de la requête de mise à jour des informations utilisateur
        $stmt = $bdd->prepare("UPDATE User SET nom = :nom, prenom = :prenom, numerotel = :numerotel WHERE email = :email");
        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':prenom', $prenom);
        $stmt->bindParam(':numerotel', $numerotel);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        // Rediriger vers la page profilform.php après la mise à jour des informations utilisateur
        header("Location: profilforme.php");
        exit();
    }

    // Si le formulaire pour la mise à jour du mot de passe est soumis
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_password'])) {
        $current_password = $_POST['current_password'];
        $new_password = $_POST['new_password'];
        $confirm_password = $_POST['confirm_password'];

        // Vérifiez que le nouveau mot de passe et la confirmation correspondent
        if ($new_password !== $confirm_password) {
            echo "Les nouveaux mots de passe ne correspondent pas.";
            exit();
        }

        // Récupérer le mot de passe actuel haché de l'utilisateur depuis la base de données
        $stmt = $bdd->prepare("SELECT pwd FROM user WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            // Vérifiez que le mot de passe actuel est correct
            if (password_verify($current_password, $user['pwd'])) {
                // Hachez le nouveau mot de passe
                $hashed_new_password = password_hash($new_password, PASSWORD_DEFAULT);

                // Mettez à jour le mot de passe haché dans la base de données
                $stmt = $bdd->prepare("UPDATE user SET pwd = :new_password WHERE email = :email");
                $stmt->bindParam(':new_password', $hashed_new_password);
                $stmt->bindParam(':email', $email);
                $stmt->execute();

                echo "Mot de passe modifié avec succès.";
                // Rediriger après la mise à jour du mot de passe
                header("Location: profilforme.php");
                exit();
            } else {
                echo "Le mot de passe actuel est incorrect.";
            }
        } else {
            echo "Utilisateur non trouvé.";
        }
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
    <script src="../scripts/confirm.js" defer></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <title>Mes Infos</title>
</head>

<body>
    <div class="header-container">
        <a href="profilforme.php">
            <div class="arrow">&lt;</div>
        </a>
        <h1 class="titre">Utilisateur</h1>
    </div>
    <div class="container">

        <form action="" method="post">
            <input type="hidden" name="update_user_info" value="1">
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
                <input type="submit" class="button-submit" value="Sauvegarder">
            </div>
        </form>

        <form action="" method="post">
            <input type="hidden" name="update_password" value="1">
            <div class="grid">
                <div class="case">
                    <label for="current_password">Mot de passe actuel :</label>
                    <input type="password" class="form-input" id="current_password" name="current_password" required>
                </div>
                <div class="case">
                    <label for="new_password">Nouveau mot de passe :</label>
                    <input type="password" class="form-input" id="new_password" name="new_password" required>
                </div>
                <div class="case">
                    <label for="confirm_password">Nouveau mot de passe :</label>
                    <input type="password" class="form-input" id="confirm_password" name="confirm_password" required>
                </div>
                <input type="submit" class="button-submit" value="Modifier le mot de passe">
            </div>
        </form>

        <a href="test-crop.php"><button class="button-submit">Modifier ma photo de profil</button></a>
        <button class="confirmButton button-submit">Supprimer mon compte</button>
    </div>
</body>

<?php require "../../php/footer.php"; ?>

</html>
