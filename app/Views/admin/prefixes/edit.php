<h2>Modifier le préfixe</h2>

<form method="post" action="/admin/prefixes/update/<?= $prefixe['idPrefixes'] ?>">

<label>Préfixe</label>

<input type="text"
       name="valeur"
       value="<?= $prefixe['valeur'] ?>">

<br>

<label>Opérateur</label>

<select class="form-control" name="idOperateurs">
    <?php foreach ($operateurs as $o): ?>
        <option value="<?= $o['idOperateurs'] ?>"
                <?= ($prefixe['idOperateurs'] == $o['idOperateurs']) ? 'selected' : '' ?>>
            <?= $o['nom'] ?>
        </option>
    <?php endforeach; ?>
</select>

<br>

<button type="submit">
Modifier
</button>

</form>