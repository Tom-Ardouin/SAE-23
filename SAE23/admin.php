<?php
session_start();
include 'includes/db.php';

if (!isset($_SESSION['admin'])) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $login = $_POST['login'];
        $mdp = $_POST['mdp'];

        $stmt = $pdo->prepare("SELECT * FROM Administration WHERE login = ? AND mdp = ?");
        $stmt->execute([$login, $mdp]);

        if ($stmt->rowCount() > 0) {
            $_SESSION['admin'] = $login;
            header("Location: admin.php");
            exit;
        } else {
            $error = "Identifiants incorrects.";
        }
    }
} else {
    // Affichage interface d'administration (CRUD simplifié)
    echo "<h1>Bienvenue Administrateur</h1>";
    echo "<a href='logout.php'>Déconnexion</a>";

    // Exemple : Ajouter un bâtiment
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['bat_nom'])) {
        $stmt = $pdo->prepare("INSERT INTO Batiment (NOM_BAT, GESTION) VALUES (?, ?)");
        $stmt->execute([$_POST['bat_nom'], $_POST['gest_id']]);
        echo "<p>Bâtiment ajouté !</p>";
    }

    echo "<form method='post'>
        Nom Bâtiment : <input type='text' name='bat_nom' required>
        ID Gestionnaire : <input type='number' name='gest_id' required>
        <input type='submit' value='Ajouter'>
    </form>";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head><title>Admin</title></head>
<link rel="stylesheet" href="css/style.css">
<body>
<h1>Connexion Administrateur</h1>
<form method="post">
    Login : <input type="text" name="login"><br>
    Mot de passe : <input type="password" name="mdp"><br>
    <input type="submit" value="Connexion">
</form>
<?php if (isset($error)) echo "<p>$error</p>"; ?>
</body>
</html>
