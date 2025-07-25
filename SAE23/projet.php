<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Rapport de Projet - SAÉ23</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <h1>Rapport de Projet – SAÉ23</h1>
    <nav>
    <a href="index.php">Accueil</a> |
    <a href="consultation.php">Consultation</a> |
    <a href="administration.php">Administration</a> |
    <a href="gestion.php">Gestion</a> |
    <a href="projet.php">Projet</a>
  </nav>
  <p><strong>Titre :</strong> Mise en place d'une solution informatique pour l’IUT de Blagnac</p>
  <p><strong>Groupe :</strong> Perin Nicolas - Ardouin Tom</p>
  <p><strong>Date :</strong> 10/06/25</p>

  <div class="section">
    <h2>1. Objectif du projet</h2>
    <p>Développer une solution pour collecter, traiter et visualiser les données de capteurs des bâtiments de l’IUT via un site web et un dashboard. Elle doit permettre une gestion des utilisateurs selon leurs rôles.</p>
	<p><strong>Diagramme de gantt :</strong></p>
	<img src="img/gantt.png" alt="gantt">
 </div>

  <div class="section">
    <h2>2. Technologies utilisées</h2>
    <table>
      <tr><th>Catégorie</th><th>Outils / Langages</th></tr>
      <tr><td>Conteneurisation</td><td>Docker (Mosquitto, Node-RED, InfluxDB, Grafana)</td></tr>
      <tr><td>Web</td><td>HTML5, CSS3, PHP</td></tr>
      <tr><td>Scripts</td><td>Bash, PHP</td></tr>
      <tr><td>Base de données</td><td>MySQL (PhpMyAdmin)</td></tr>
      <tr><td>Collaboration</td><td>GitHub, Trello, Drive</td></tr>
    </table>
  </div>

  <div class="section">
    <h2>3. Architecture du système</h2>
    <p>Les capteurs envoient des données MQTT traitées par Node-RED, stockées dans InfluxDB et affichées via Grafana. Le site web PHP interagit avec MySQL pour la gestion et la visualisation des données selon les droits des utilisateurs.</p>
    <p><strong>Node-RED :</strong></p>
	<img src="img/Node-RED1.png" alt="Node-RED1">
	<img src="img/Node-RED2.png" alt="Node-RED2">
	<p><strong>Bâtiment RT Grafana:</strong></p>
	<img src="img/GrafanaRT.png" alt="GrafanaRT">
	<p><strong>Bâtiment INFO-GIM Grafana:</strong></p>
	<img src="img/GrafanaIG.png" alt="GrafanaIG">
  </div>
  <div class="section">
    <h2>4. Gestion des utilisateurs</h2>
    <ul>
      <li><strong>Administrateur</strong> : Gère les bâtiments, salles et capteurs.</li>
      <li><strong>Gestionnaire</strong> : Visualise les données liées à son bâtiment.</li>
      <li><strong>Visiteur</strong> : Accède à la consultation des dernières mesures.</li>
    </ul>
  </div>

  <div class="section">
    <h2>5. Base de données</h2>
    <p>Structure relationnelle conforme :</p>
    <ul>
      <li><strong>Bâtiments</strong>, <strong>Salles</strong>, <strong>Capteurs</strong>, <strong>Mesures</strong>, <strong>Administration</strong></li>
    </ul>
	<p><strong>PhpMyAdmin :</strong></p>
	<img src="img/PhpMyAdmin.png" alt="PhpMyAdmin">
  </div>

  <div class="section">
    <h2>6. Répartition du travail</h2>
    <table>
      <tr><th>Membre</th><th>Tâches principales</th></tr>
      <tr><td>Ardouin Tom</td><td>Développement du site web</td></tr>
      <tr><td>Perin Nicolas</td><td>Dashboard Node-RED / Grafana</td></tr>
      <tr><td>Perin Nicolas</td><td>Modélisation base de données</td></tr>
      <tr><td>Ardouin Tom</td><td>Coordination et documentation</td></tr>
    </table>
  </div>

  <div class="section">
    <h2>7. Difficultés et solutions</h2>
    <table>
      <tr><th>Problème</th><th>Solution</th></tr>
      <tr><td>difficultés avec la mise en place de GitHub</td><td>prise en main du logiciel</td></tr>
      <tr><td>Récupération des donnés depuis PhpMyAdmin</td><td>probléme non résolu</td></tr>
      <tr><td>absent dans le groupe</td><td></td></tr>
    </table>
  </div>

  <div class="section">
    <h2>8. Conclusion</h2>
    <p>Ce projet a renforcé nos compétences en développement web, traitement de données IoT et gestion de projet collaboratif. Maleureusement tous les objectifs n'ont pas été atteints, avec possibilité d’ajouts futurs (plus de capteurs, meilleure ergonomie, etc.).</p>
  </div>

</body>
</html>
