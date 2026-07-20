<h2>Gestion des préfixes</h2>

<a href="prefixes/create">
    Ajouter un préfixe
</a>

<table border="1">
    <tr>
        <th>ID</th>
        <th>Préfixe</th>
        <th>Opérateur</th>
        <th>Actions</th>
    </tr>

<?php foreach($prefixes as $p): ?>

<tr>
    <td><?= $p['idPrefixes'] ?></td>
    <td><?= $p['valeur'] ?></td>
    <td><?= $p['operateur'] ?></td>

    <td>
        <a href="prefixes/edit/<?= $p['idPrefixes'] ?>">
            Modifier
        </a>

        <a href="prefixes/delete/<?= $p['idPrefixes'] ?>"
           onclick="return confirm('Supprimer ce préfixe ?')">
            Supprimer
        </a>
    </td>
</tr>

<?php endforeach; ?>

</table>