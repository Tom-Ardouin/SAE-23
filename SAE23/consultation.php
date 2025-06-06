<!-- consultation.php -->
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Consultation</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <h1>Dernières mesures des capteurs</h1>
  <nav>
    <a href="index.php">Accueil</a> |
    <a href="consultation.php">Consultation</a> |
    <a href="administration.php">Administration</a> |
    <a href="gestion.php">Gestion</a> |
    <a href="projet.php">Projet</a>
  </nav>
  <?php
  include 'includes/db.php';
  $sql = "SELECT c.NOM_CAPT, m.VAL, m.Date_MESU, m.HOR FROM Mesure m
          JOIN Capteur c ON m.CAPT = c.NOM_CAPT
          WHERE (m.Date_MESU, m.HOR) IN (
              SELECT MAX(Date_MESU), MAX(HOR) FROM Mesure GROUP BY CAPT
          )";
  $res = $conn->query($sql);
  echo "<table><tr><th>Capteur</th><th>Valeur</th><th>Date</th><th>Heure</th></tr>";
  while($row = $res->fetch_assoc()) {
    echo "<tr><td>{$row['NOM_CAPT']}</td><td>{$row['VAL']}</td><td>{$row['Date_MESU']}</td><td>{$row['HOR']}</td></tr>";
  }
  echo "</table>";
  ?>
</body>
</html>