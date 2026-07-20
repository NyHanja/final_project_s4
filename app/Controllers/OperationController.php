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

    public function voirHistorique()
    {
        $idUtilisateur = session()->get('idUtilisateurs');

        if (!$idUtilisateur) {
            return redirect()->to('/login');
        }

        $operationModel   = new \App\Models\OperationsModel();
        $utilisateurModel = new \App\Models\UtilisateursModel();

        $utilisateur = $utilisateurModel->find($idUtilisateur);
        $historique  = $operationModel->getHistorique($idUtilisateur);

        return view('client/historique', [
            'utilisateur' => $utilisateur,
            'historique'  => $historique,
        ]);
    }
    public function depotForm()
    {
        return view('client/depot');
    }

    public function depot()
    {
        $idUtilisateur = session()->get('idUtilisateurs');
        if (!$idUtilisateur) {
            return redirect()->to('/login');
        }

        $montant = (int) $this->request->getPost('montant');

        $operationModel = new \App\Models\OperationsModel();
        $dateOperation = $this->request->getPost('dateOperation');
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
        $idUtilisateur = session()->get('idUtilisateurs');
        if (!$idUtilisateur) {
            return redirect()->to('/login');
        }

        $montant = (int) $this->request->getPost('montant');

        $operationModel = new \App\Models\OperationsModel();
        $dateOperation = $this->request->getPost('dateOperation');
        $resultat = $operationModel->effectuerRetrait($idUtilisateur, $montant, $dateOperation);

        return redirect()->to('/client/solde')->with(
            $resultat['success'] ? 'success' : 'error',
            $resultat['message']
        );
    }

    public function transfertForm()
    {
        return view('client/transfert');
    }

    public function transfert()
    {
        $idUtilisateur = session()->get('idUtilisateurs');
        if (!$idUtilisateur) {
            return redirect()->to('/login');
        }

        $numeroDestinataire = $this->request->getPost('numeroTelephone');
        $montant = (int) $this->request->getPost('montant');

        $operationModel = new \App\Models\OperationsModel();
        $dateOperation = $this->request->getPost('dateOperation');
        $resultat = $operationModel->effectuerTransfert($idUtilisateur, $numeroDestinataire, $montant, $dateOperation);

        return redirect()->to('/client/solde')->with(
            $resultat['success'] ? 'success' : 'error',
            $resultat['message']
        );
    }
}
