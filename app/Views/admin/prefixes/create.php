<form method="post" action="<?= base_url('admin/prefixes/store') ?>">


    <div class="mb-3">

        <label>
            Préfixe
        </label>

        <input class="form-control" name="valeur" placeholder="033">


    </div>



    <div class="mb-3">

        <label>
            Opérateur
        </label>


        <select class="form-control" name="idOperateurs">


            <?php foreach ($operateurs as $o): ?>

                <option value="<?= $o['idOperateurs'] ?>">

                    <?= $o['nom'] ?>

                </option>


            <?php endforeach; ?>


        </select>


    </div>



    <button class="btn btn-success">
        Enregistrer
    </button>


</form>