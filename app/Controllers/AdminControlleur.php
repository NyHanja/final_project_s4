<?php

namespace App\Controllers;

class AdminControlleur extends BaseController
{
    public function dashboard(): string
    {
        $operationModel = new \App\Models\OperationsModel();
        $data['gain'] = $operationModel->gain();
        return view('admin/dashboard', $data);
    }

    public function operations(): string
    {
        $operationModel = new \App\Models\OperationsModel();
        $data['operations'] = $operationModel->findAll(); // Récupère tout l'historique global

        return view('admin/operations', $data);
    }

    public function frais(): string
    {
        $fraisModel = new \App\Models\FraisModel();
        $data['frais'] = $fraisModel->findAll();

        return view('admin/frais', $data);
    }

    public function typesOperations(): string
    {
        $typeModel = new \App\Models\TypesOperationsModel();
        $data['types'] = $typeModel->findAll();

        return view('admin/types_operations', $data);
    }
}