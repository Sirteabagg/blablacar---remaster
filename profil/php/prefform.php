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

    // Si le formulaire est soumis, mettre à jour les préférences de voyage de l'utilisateur
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $pref1 = $_POST['pref1'];
        $pref2 = $_POST['pref2'];
        $pref3 = $_POST['pref3'];
        $pref4 = $_POST['pref4'];

        // Vérifiez si une ligne existe pour cet email
        $stmt = $bdd->prepare("SELECT idPref FROM preferences WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            // Mettre à jour les préférences de l'utilisateur existant
            $stmt = $bdd->prepare("UPDATE preferences SET pref1 = :pref1, pref2 = :pref2, pref3 = :pref3, pref4 = :pref4 WHERE email = :email");
        } else {
            // Insérer une nouvelle ligne pour l'utilisateur
            $stmt = $bdd->prepare("INSERT INTO preferences (email, pref1, pref2, pref3, pref4) VALUES (:email, :pref1, :pref2, :pref3, :pref4)");
        }

        $stmt->bindParam(':pref1', $pref1);
        $stmt->bindParam(':pref2', $pref2);
        $stmt->bindParam(':pref3', $pref3);
        $stmt->bindParam(':pref4', $pref4);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        // Rediriger vers la page prefform.php après la mise à jour
        header("Location: prefform.php");
        exit(); // Assurez-vous de sortir pour éviter l'exécution ultérieure du script
    }

    // Préparation et exécution de la requête pour récupérer les préférences de voyage de l'utilisateur
    $stmt = $bdd->prepare("SELECT pref1, pref2, pref3, pref4 FROM preferences WHERE email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    // Récupération des préférences de voyage de l'utilisateur
    $preferences = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$preferences) {
        // Si l'utilisateur n'a pas encore de préférences, définir des valeurs par défaut
        $preferences = [
            'pref1' => '',
            'pref2' => '',
            'pref3' => '',
            'pref4' => ''
        ];
    }
} catch (Exception $e) {
    die("Erreur : " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/style-main-structure.css">
    <link rel="stylesheet" href="../styles/prefform.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="../scripts/prefform.js" defer></script>
    <title>Document</title>
</head>
<body>    
    <div class="header-container">
        <a href="profilforme.php"><div class="arrow">&lt;</div></a>
        <h1 class="titre">Conducteur</h1>
    </div>
    <div class="menu">
        <div class="itemss">Infos véhicule
            <div class="fleche">&#9660;</div>
            <div class="content">
                <form action="" method="post">
                    <div class="grid">
                        <div class="case"><label for="marque">Marque :</label><input type="text" placeholder="Peugeot" name="marque" class="form-input"></div>
                        <div class="case"><label for="modèle">Modèle :</label><input type="text" placeholder="3008" name="modèle" class="form-input"></div>
                        <div class="case"><label for="couleur">Couleur :</label><input type="text" placeholder="Blanc" name="couleur" class="form-input"></div>
                        <div class="case"><label for="immat">Immatriculation :</label><input type="text" placeholder="FN-911-HK" name="immat" class="form-input"></div>
                        <input type="submit" class="button-submit" value="Sauvegarder">
                    </div>
                </form>
            </div>
        </div>
        <div class="itemss">Préférences de voyage
            <div class="fleche2">&#9660;</div>
            <div class="content2">
                <form action="" method="post">
                    <div class="grid">
                        <div class="case"><label for="pref1">Discussion :</label><input type="text" placeholder="Je suis discret" name="pref1" class="form-input" value="<?php echo htmlspecialchars($preferences['pref1'] ?? ''); ?>"></div>
                        <div class="case"><label for="pref2">Cigarette :</label><input type="text" placeholder="Non" name="pref2" class="form-input" value="<?php echo htmlspecialchars($preferences['pref2'] ?? ''); ?>"></div>
                        <div class="case"><label for="pref3">Musique :</label><input type="text" placeholder="Tout le long" name="pref3" class="form-input" value="<?php echo htmlspecialchars($preferences['pref3'] ?? ''); ?>"></div>
                        <div class="case"><label for="pref4">Animaux :</label><input type="text" placeholder="Oui" name="pref4" class="form-input" value="<?php echo htmlspecialchars($preferences['pref4'] ?? ''); ?>"></div>
                        <input type="submit" class="button-submit" value="Sauvegarder">
                    </div>
                </form>
            </div>
        </div>
        <div class="itemss">
            <div>N°Permis</div>
            <div>&gt;</div>
        </div>
        <div class="itemss">
            <div>Photo permis de conduire</div>
            <div>&gt;</div>
        </div>
    </div>
</body>
</html>
