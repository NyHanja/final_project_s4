<?php

namespace App\Controllers;

class OperationController extends BaseController
{
    public function index(): string
    {
        return view('operation');
    }

    public function VoirSolde()
    {
        $idUtilisateur = session()->get('idUtilisateurs');

        if (!$idUtilisateur) {
            return redirect()->to('/login');
        }

        $operationModel = new \App\Models\OperationsModel();
        $solde = $operationModel->getSolde($idUtilisateur);

        return view('client/solde', ['solde' => $solde]);
    }
}
