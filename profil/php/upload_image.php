<?php
session_start();

if (isset($_FILES['croppedImage'])) {
    $email = $_SESSION["current-user-email"];
    $image = $_FILES['croppedImage']['tmp_name'];
    $imgData = file_get_contents($image);

    require "../../php/config.php";

    // Créer la table si elle n'existe pas
    // Récupérer la photo de profil de l'utilisateur
    $request = $bdd->prepare("SELECT pdp FROM user WHERE email = :email");
    $request->bindParam(':email', $email);
    $request->execute();
    $user = $request->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // Mettre à jour la photo de profil de l'utilisateur existant
        $request = $bdd->prepare("UPDATE user SET pdp = :pdp WHERE email = :email");
    } else {
        // Insérer une nouvelle ligne pour l'utilisateur
        $request = $bdd->prepare("INSERT INTO user (email, pdp) VALUES (:email, :pdp)");
    }

    $request->bindParam(':pdp', $imgData, PDO::PARAM_LOB);
    $request->bindParam(':email', $email);
    $request->execute();
    if ($request->execute()) {
        echo "Image uploaded successfully!";
    } else {
        echo "Failed to upload image.";
    }
} else {
    echo "No image uploaded.";
}
