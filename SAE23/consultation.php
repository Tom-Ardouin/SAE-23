<?php
include 'includes/db.php';
?>
<!DOCTYPE html>
<html>
<head>
    <title>Consultation</title>
	<link rel="stylesheet" href="css/style.css">
</head>
<body>
<h1>Dernières mesures des capteurs</h1>
<table border="1">
<tr><th>Capteur</th><th>Valeur</th><th>Date</th></tr>
<?php
$sql = "SELECT m.CAPT, m.VAL, m.DATE_MESU 
        FROM Mesure m 
        JOIN (
            SELECT CAPT, MAX(DATE_MESU) AS max_date 
            FROM Mesure GROUP BY CAPT
        ) latest ON m.CAPT = latest.CAPT AND m.DATE_MESU = latest.max_date";

$stmt = $pdo->query($sql);
foreach ($stmt as $row) {
    echo "<tr><td>{$row['CAPT']}</td><td>{$row['VAL']}</td><td>{$row['DATE_MESU']}</td></tr>";
}
?>
</table>
</body>
</html>
