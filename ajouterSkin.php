<?php
require_once __DIR__ . '/config/config.php';
require_once BASE_PATH . '/src/connexion.php';
$titrePage = "Ajouter un skin";
require_once BASE_PATH . '/includes/headers.php';

$pdo = connexionBdd();

$armes     = $pdo->query("SELECT id_arme, nom FROM Arme ORDER BY nom")->fetchAll();
$finitions = $pdo->query("SELECT id_finition, nom FROM Finition ORDER BY nom")->fetchAll();
?>
<main class="contenu">
    <h2>Ajouter un skin</h2>

    <form method="post" class="formulaire">

        <label for="id_arme">Arme</label>
        <select name="id_arme" id="id_arme" required>
            <option value="">-- Choisir une arme --</option>
            <?php foreach ($armes as $arme) : ?>
                <option value="<?= $arme['id_arme'] ?>"><?= htmlspecialchars($arme['nom']) ?></option>
            <?php endforeach; ?>
        </select>

        <label for="id_finition">Finition</label>
        <select name="id_finition" id="id_finition" required>
            <option value="">-- Choisir une finition --</option>
            <?php foreach ($finitions as $finition) : ?>
                <option value="<?= $finition['id_finition'] ?>"><?= htmlspecialchars($finition['nom']) ?></option>
            <?php endforeach; ?>
        </select>

        <label for="rarete">Rareté</label>
        <select name="rarete" id="rarete" required>
            <option value="">-- Choisir une rareté --</option>
            <option>Consumer Grade</option>
            <option>Industrial Grade</option>
            <option>Mil-Spec</option>
            <option>Restricted</option>
            <option>Classified</option>
            <option>Covert</option>
            <option>Contraband</option>
        </select>

        <label for="collection">Collection</label>
        <input type="text" name="collection" id="collection" placeholder="The Phoenix Collection">

        <label for="float_min">Float min</label>
        <input type="number" name="float_min" id="float_min" min="0" max="1" step="0.000000001" value="0" required>

        <label for="float_max">Float max</label>
        <input type="number" name="float_max" id="float_max" min="0" max="1" step="0.000000001" value="1" required>

        <button type="submit">Ajouter le Skin</button>
    </form>
</main>

<?php require_once BASE_PATH . '/includes/footer.php'; ?>