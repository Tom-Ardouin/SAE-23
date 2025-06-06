<?php
// Connexion à la base de données MySQL
$host = 'localhost';
$user = 'sae23PA';
$password = 'passroot';
$dbname = 'sae23';
$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die(" Erreur de connexion : " . $conn->connect_error);
}

// Récupération du message MQTT (1 message)
$json = shell_exec("mosquitto_sub -h mqtt.iut-blagnac.fr -t AM107/by-room/E104/data -C 1");
$data = json_decode($json, true);

// Vérifie que le JSON est bien reçu et exploitable
if (!$data || !isset($data["measurements"]) || !isset($data["room"])) {
    die(" Format JSON incorrect ou message vide.");
}

// Extraction des données
$mesures = $data["measurements"];
$nomSalle = $data["room"];
$date = date('Y-m-d');
$heure = date('H:i:s');

// Liste des capteurs à traiter
$capteurs = [
    "temperature" => "°C",
    "humidity" => "%",
    "activity" => "",
    "co2" => "ppm",
    "tvoc" => "ppb",
    "illumination" => "lux",
    "infrared" => "",
    "infrared_and_visible" => "",
    "pressure" => "hPa"
];

// 1. Insertion de la salle si elle n'existe pas
$stmtSalle = $conn->prepare("INSERT IGNORE INTO Salle (NOM_SA) VALUES (?)");
$stmtSalle->bind_param("s", $nomSalle);
$stmtSalle->execute();

// 2. Traitement des capteurs
foreach ($capteurs as $nom => $unite) {
    if (!isset($mesures[$nom])) continue; // Ne traite que les capteurs présents dans le message

    $valeur = $mesures[$nom];
    $nomCapteur = $nom . "_" . $nomSalle;

    //  Insérer le capteur s'il n'existe pas
    $stmtCapt = $conn->prepare("INSERT IGNORE INTO Capteur (NOM_CAPT, TYPE_CAPT, UNITE, SALLE) VALUES (?, ?, ?, ?)");
    $stmtCapt->bind_param("ssss", $nomCapteur, $nom, $unite, $nomSalle);
    $stmtCapt->execute();

    //  Insérer la mesure
    $stmtMesure = $conn->prepare("INSERT INTO Mesure (Date_MESU, HOR, VAL, CAPT) VALUES (?, ?, ?, ?)");
    $stmtMesure->bind_param("ssds", $date, $heure, $valeur, $nomCapteur);
    $stmtMesure->execute();
}

echo " Mesures insérées avec succès.\n";
$conn->close();
?>
