<?php
session_start();
include 'includes/db.php';

$erreur = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login = $_POST['login'];
    $mdp = $_POST['mdp'];

    // Vérification dans la base
    $stmt = $conn->prepare("SELECT * FROM Administration WHERE login = ? AND mdp = ?");
    $stmt->bind_param("ss", $login, $mdp);
    $stmt->execute();
    $result = $stmt->get_result();

    // Si trouvé, on connecte
    if ($result->num_rows == 1) {
        $_SESSION['admin'] = $login;
        header("Location: administration.php");
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
  <title>Connexion Admin</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <h1>Connexion administrateur</h1>
  <?php if ($erreur) echo "<p style='color:red;'>$erreur</p>"; ?>
  <form method="post">
    <label>Login : <input type="text" name="login" required></label><br><br>
    <label>Mot de passe : <input type="password" name="mdp" required></label><br><br>
    <input type="submit" value="Connexion">
  </form>
  <a href="index.php">Retour à l'accueil</a>
</body>
</html>
