<?php
// Connexion à la base de données
include 'includes/db.php';

// Récupération des données JSON brutes envoyées via POST
$json = file_get_contents('php://input');
$data = json_decode($json, true);

// Vérification du format
if (!is_array($data) || count($data) < 2) {
    http_response_code(400);
    echo "Format JSON invalide.";
    exit;
}

// Séparation des données
$mesures = $data[0]; // ex: { "temperature": 22.3, "humidite": 60.2 }
$infos = $data[1];   // ex: { "devEUI": "EUI123", "room": "Salle101", "Building": "BatA" }

// Définition de valeurs
$devEUI = $conn->real_escape_string($infos['devEUI']);
$room = $conn->real_escape_string($infos['room']);
$building = $conn->real_escape_string($infos['Building']);
$date = date("Y-m-d");
$heure = date("H:i:s");

// Étape 1 : Gestionnaire par défaut (id 1)
$id_gest = 1;
$conn->query("INSERT IGNORE INTO Gestionnaire (ID_GEST, MDP) VALUES ($id_gest, 'default')");

// Étape 2 : Bâtiment
$conn->query("INSERT IGNORE INTO Batiment (NOM_BAT, GESTION) VALUES ('$building', $id_gest)");
$res = $conn->query("SELECT ID_BAT FROM Batiment WHERE NOM_BAT = '$building'");
$row = $res->fetch_assoc();
$id_bat = $row['ID_BAT'];

// Étape 3 : Salle
$conn->query("INSERT IGNORE INTO Salle (NOM_SA, TYPE_SA, CAP, BAT) VALUES ('$room', 'standard', 0, $id_bat)");
$res = $conn->query("SELECT NOM_SA FROM Salle WHERE NOM_SA = '$room'");
$row = $res->fetch_assoc();
$nom_salle = $row['NOM_SA'];

// Étape 4 : Pour chaque capteur, on insère dans Capteur et Mesure
foreach ($mesures as $type => $valeur) {
    $nom_capt = $devEUI . "_" . $type;
    $type_capt = $conn->real_escape_string($type);
    $unit = ""; // tu peux adapter selon le type (ex: °C, %, etc.)

    // Capteur
    $conn->query("INSERT IGNORE INTO Capteur (NOM_CAPT, TYPE_CAPT, UNIT, SALLE)
                  VALUES ('$nom_capt', '$type_capt', '$unit', '$nom_salle')");

    // Mesure
    $stmt = $conn->prepare("INSERT INTO Mesure (DATE_MESU, HOR, VAL, CAPT) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssds", $date, $heure, $valeur, $nom_capt);
    $stmt->execute();
}

http_response_code(200);
echo "Données enregistrées avec succès.";
?>
