<!DOCTYPE html>
<html>

<head>

    <title>Commissions</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

</head>


<body class="bg-light">


    <div class="container mt-5">


        <h2>
            Commission des autres opérateurs
        </h2>


        <a href="<?= base_url('admin/commissions/create') ?>" class="btn btn-primary mb-3">

            Ajouter commission

        </a>



        <table class="table table-bordered bg-white">


            <tr>

                <th>
                    Opérateur
                </th>


                <th>
                    Pourcentage
                </th>


                <th>
                    Action
                </th>


            </tr>



            <?php foreach ($commissions as $c): ?>


                <tr>


                    <td>

                        <?= $c['nom'] ?>

                    </td>


                    <td>

                        <?= $c['pourcentage'] ?> %

                    </td>



                    <td>


                        <a href="<?= base_url('admin/commissions/edit/' . $c['idCommissions']) ?>"
                            class="btn btn-warning btn-sm">

                            Modifier

                        </a>



                        <a href="<?= base_url('admin/commissions/delete/' . $c['idCommissions']) ?>"
                            class="btn btn-danger btn-sm">

                            Supprimer

                        </a>


                    </td>



                </tr>


            <?php endforeach; ?>


        </table>


    </div>


</body>

</html>