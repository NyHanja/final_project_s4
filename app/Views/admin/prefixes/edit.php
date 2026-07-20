<h2>Modifier le préfixe</h2>

<form method="post" action="admin/prefixes/update/<?= $prefixe['idPrefixes'] ?>">

<label>Préfixe</label>

<input type="text"
       name="valeur"
       value="<?= $prefixe['valeur'] ?>">

<br>

<label>Opérateur</label>

<input type="text"
       name="operateur"
       value="<?= $prefixe['operateur'] ?>">

<br>

<button type="submit">
Modifier
</button>

</form>