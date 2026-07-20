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
        $idUtilisateur = session()->get('idUtilisateur');

        if (!$idUtilisateur) {
            return redirect()->to('/login');
        }

        $operationModel = new \App\Models\OperationsModel();
        $utilisateurModel = new \App\Models\UtilisateursModel();

        $solde = $operationModel->getSolde($idUtilisateur);
        $utilisateur = $utilisateurModel->find($idUtilisateur);

        return view('client/solde', [
            'solde' => $solde,
            'utilisateur' => $utilisateur,
        ]);
    }

    public function voirHistorique()
    {
        $idUtilisateur = session()->get('idUtilisateur');
        if (!$idUtilisateur) {
            return redirect()->to('/');
        }

        $operationModel   = new \App\Models\OperationsModel();
        $utilisateurModel = new \App\Models\UtilisateursModel();
        $typeModel        = new \App\Models\TypesOperationsModel();

        $filtres = [
            'dateDebut'         => $this->request->getGet('dateDebut'),
            'dateFin'           => $this->request->getGet('dateFin'),
            'idTypesOperations' => $this->request->getGet('idTypesOperations'),
        ];

        $utilisateur = $utilisateurModel->find($idUtilisateur);
        $historique  = $operationModel->getHistorique($idUtilisateur, array_filter($filtres, static function ($value) {
            return $value !== null && $value !== '';
        }));
        $types       = $typeModel->findAll();

        return view('client/historique', [
            'utilisateur' => $utilisateur,
            'operations'  => $historique,
            'types'       => $types,
            'filtres'     => $filtres,
        ]);
    }

    public function depotForm()
    {
        return view('client/depot');
    }

    public function depot()
    {
        $idUtilisateur = session()->get('idUtilisateur');
        if (!$idUtilisateur) {
            return redirect()->to('/login');
        }

        $montant = (int) $this->request->getPost('montant');
        $dateOperation = $this->request->getPost('dateOperation');

        if (empty($dateOperation)) {
            $dateOperation = date('Y-m-d H:i:s');
        }

        $operationModel = new \App\Models\OperationsModel();
        $resultat = $operationModel->effectuerDepot($idUtilisateur, $montant, $dateOperation);

        return redirect()->to('/client/solde')->with(
            $resultat['success'] ? 'success' : 'error',
            $resultat['message']
        );
    }

    public function retraitForm()
    {
        return view('client/retrait');
    }

    public function retrait()
    {
        $idUtilisateur = session()->get('idUtilisateur');
        if (!$idUtilisateur) {
            return redirect()->to('/login');
        }

        try {
            $montant = (int) $this->request->getPost('montant');

            $operationModel = new \App\Models\OperationsModel();
            $dateOperation = $this->request->getPost('dateOperation');
            $resultat = $operationModel->effectuerRetrait($idUtilisateur, $montant, $dateOperation);

            return redirect()->to('/client/solde')->with(
                $resultat['success'] ? 'success' : 'error',
                $resultat['message']
            );
        } catch (\RuntimeException $exception) {
            return redirect()->to('/client/solde')->with('error', $exception->getMessage());
        }
    }

    public function transfertForm()
    {
        return view('client/transfert');
    }

    public function transfert()
    {
        $idUtilisateur = session()->get('idUtilisateur');
        if (!$idUtilisateur) {
            return redirect()->to('/login');
        }

        try {
            $numeroDestinataire = $this->request->getPost('numeroTelephone');
            $montant = (int) $this->request->getPost('montant');

            $operationModel = new \App\Models\OperationsModel();
            $dateOperation = $this->request->getPost('dateOperation');
            $resultat = $operationModel->effectuerTransfert($idUtilisateur, $numeroDestinataire, $montant, $dateOperation);

            return redirect()->to('/client/solde')->with(
                $resultat['success'] ? 'success' : 'error',
                $resultat['message']
            );
        } catch (\RuntimeException $exception) {
            return redirect()->to('/client/solde')->with('error', $exception->getMessage());
        }
    }
}
