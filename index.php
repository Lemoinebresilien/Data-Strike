<?php
require_once __DIR__ . '/config/config.php';
$titrePage = "Acceuil data-strike";
require_once BASE_PATH . '/includes/headers.php';
require_once BASE_PATH . '/src/connexion.php';

$pdo = connexionBdd();

$nbSkins       = $pdo->query("SELECT COUNT(*) FROM Skin")->fetchColumn();
$nbExemplaires = $pdo->query("SELECT COUNT(*) FROM Exemplaire")->fetchColumn();
$nbArmes       = $pdo->query("SELECT COUNT(*) FROM Arme")->fetchColumn();


//Requete gentillement preparée par Claude.
$derniersSkins = $pdo->query("
    SELECT Arme.nom AS nom_arme,
           Finition.nom AS nom_finition,
           Skin.rarete,
           Skin.image,
           Exemplaire.float_valeur
    FROM Exemplaire
    JOIN Skin     ON Exemplaire.id_skin = Skin.id_skin
    JOIN Arme     ON Skin.id_arme = Arme.id_arme
    JOIN Finition ON Skin.id_finition = Finition.id_finition
    ORDER BY Exemplaire.id_exemplaire DESC
    LIMIT 4
")->fetchAll();
?>



<main class="contenu">
    <h2>Data-strike est une BDD pour ajouter un Skin et le lister.</h2>
    <div class="gif">
        <video id="gif-cs2" src="https://media.giphy.com/media/TgvOsOZ91BCdp2Mivs/giphy.mp4"
            width="480" autoplay loop muted playsinline></video>
        <p><a href="https://giphy.com/gifs/NVIDIA-GeForce-nvidia-rtx-geforce-TgvOsOZ91BCdp2Mivs">via GIPHY</a></p>
    </div>

    <script>
        document.getElementById("gif-cs2").playbackRate = 0.7;
    </script>
    <div class="boiteStats">
        <h3>Données de la Base</h3>
        <div class="stats">
            <div class="stat">
                <span class="nombre"><?= e($nbSkins) ?></span>
                <span class="label">Skins</span>
            </div>
            <div class="stat">
                <span class="nombre"><?= e($nbExemplaires) ?></span>
                <span class="label">Exemplaires</span>
            </div>
            <div class="stat">
                <span class="nombre"><?= e($nbArmes) ?></span>
                <span class="label">Armes</span>
            </div>
        </div>
    </div>
    
    <div class="derniers">
        <h3>Derniers ajouts (Desc)</h3>
        <?php foreach ($derniersSkins as $skin) : ?>
            <div class="carte">
                <img src="<?= htmlspecialchars($skin['image']) ?>"
                    alt="<?= htmlspecialchars($skin['nom_arme'] . ' | ' . $skin['nom_finition']) ?>">
                <span class="carte-nom">
                    <?= htmlspecialchars($skin['nom_arme']) ?> | <?= htmlspecialchars($skin['nom_finition']) ?>
                </span>
                <span class="carte-rarete"><?= htmlspecialchars($skin['rarete']) ?></span>
                <span class="carte-float">Float : <?= $skin['float_valeur'] ?></span>
            </div>
        <?php endforeach; ?>
    </div>
</main>
<?php
require_once BASE_PATH . '/includes/footer.php';
?>

</body>