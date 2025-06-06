<?php
session_start();
include 'includes/db.php';

if (!isset($_SESSION['gestionnaire'])) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $id = $_POST['id'];
        $mdp = $_POST['mdp'];

        $stmt = $pdo->prepare("SELECT * FROM Gestionnaire WHERE ID_GEST = ? AND MDP = ?");
        $stmt->execute([$id, $mdp]);

        if ($stmt->rowCount() > 0) {
            $_SESSION['gestionnaire'] = $id;
            header("Location: gestionnaire.php");
            exit;
        } else {
            $error = "Identifiants incorrects.";
        }
    }
} else {
    $id_gest = $_SESSION['gestionnaire'];
    echo "<h1>Mesures capteurs - Gestionnaire #$id_gest</h1>";
    echo "<a href='logout.php'>Déconnexion</a>";

    // Rechercher bâtiments
    $stmt = $pdo->prepare("SELECT ID_BAT FROM Batiment WHERE GESTION = ?");
    $stmt->execute([$id_gest]);
    $bats = $stmt->fetchAll(PDO::FETCH_COLUMN);

    if ($bats) {
        $placeholders = implode(',', array_fill(0, count($bats), '?'));

        // Moyennes par salle
        $sql = "SELECT s.NOM_SA, AVG(m.VAL) as moyenne, MIN(m.VAL) as min, MAX(m.VAL) as max
                FROM Mesure m
                JOIN Capteur c ON m.CAPT = c.NOM_CAPT
                JOIN Salle s ON c.SALLE = s.NOM_SA
                WHERE s.BAT IN ($placeholders)
                GROUP BY s.NOM_SA";
        $stmt = $pdo->prepare($sql);
        $stmt->execute($bats);
        echo "<table border='1'><tr><th>Salle</th><th>Moy</th><th>Min</th><th>Max</th></tr>";
        foreach ($stmt as $row) {
            echo "<tr><td>{$row['NOM_SA']}</td><td>{$row['moyenne']}</td><td>{$row['min']}</td><td>{$row['max']}</td></tr>";
        }
        echo "</table>";
    } else {
        echo "<p>Aucun bâtiment associé.</p>";
    }
    exit;
}
?>

<!DOCTYPE html>
<html>
<head><title>Gestionnaire</title></head>
<link rel="stylesheet" href="css/style.css">
<body>
<h1>Connexion Gestionnaire</h1>
<form method="post">
    ID : <input type="number" name="id"><br>
    Mot de passe : <input type="password" name="mdp"><br>
    <input type="submit" value="Connexion">
</form>
<?php if (isset($error)) echo "<p>$error</p>"; ?>
</body>
</html>
