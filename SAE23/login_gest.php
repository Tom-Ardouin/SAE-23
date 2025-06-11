<?php
session_start();
include 'includes/db.php';

$erreur = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_gest = $_POST['id_gest'];
    $mdp = $_POST['mdp'];

    // Vérification dans la base
    $stmt = $conn->prepare("SELECT * FROM Gestionnaire WHERE ID_GEST = ? AND MDP = ?");
    $stmt->bind_param("is", $id_gest, $mdp);
    $stmt->execute();
    $result = $stmt->get_result();

    // Si trouvé, on connecte
    if ($result->num_rows == 1) {
        $_SESSION['gestionnaire'] = $id_gest;
        header("Location: gestion.php");
        exit();
    } else {
        $erreur = "Identifiants incorrects.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Connexion Gestionnaire</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <h1>Connexion gestionnaire</h1>
  <?php if ($erreur) echo "<p style='color:red;'>$erreur</p>"; ?>
  <form method="post">
    <label>ID Gestionnaire : <input type="number" name="id_gest" required></label><br><br>
    <label>Mot de passe : <input type="password" name="mdp" required></label><br><br>
    <input type="submit" value="Connexion">
  </form>
  <a href="index.php">Retour à l'accueil</a>
</body>
</html>
