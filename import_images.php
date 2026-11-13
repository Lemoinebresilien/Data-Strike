<?php
require_once __DIR__ . '/config/config.php';
require_once BASE_PATH . '/src/connexion.php';

$pdo = connexionBdd();

//On telecharge le fichier JSON qui contient les données
$json = file_get_contents('https://raw.githubusercontent.com/ByMykel/CSGO-API/main/public/api/en/skins.json');
$skinsApi = json_decode($json, true);

//On ranges les images dans un tableau avec le nom en clé
$images = [];
foreach ($skinsApi as $s) {
    $images[$s['name']] = $s['image'];
}

//On lance la rwquete pour recuperer les skins avec leur nom
$nosSkins = $pdo->query("
    SELECT Skin.id_skin, Arme.nom AS nom_arme, Finition.nom AS nom_finition
    FROM Skin
    JOIN Arme     ON Skin.id_arme = Arme.id_arme
    JOIN Finition ON Skin.id_finition = Finition.id_finition
")->fetchAll();

//Pour chaque skins on enregistre l'image
$update = $pdo->prepare("UPDATE Skin SET image = ? WHERE id_skin = ?");

foreach ($nosSkins as $skin) {
    $nom = $skin['nom_arme'] . ' | ' . $skin['nom_finition'];

    if (isset($images[$nom])) {
        $update->execute([$images[$nom], $skin['id_skin']]);
        echo "✅ " . htmlspecialchars($nom) . "<br>";
    } else {
        echo "❌ Pas trouvé : " . htmlspecialchars($nom) . "<br>";
    }
}