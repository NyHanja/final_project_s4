<?php

namespace App\Controllers;

class ClientControlleur extends BaseController
{
    public function dashboard(): string
    {
        return view('client/dashboard');
    }

    public function operations(): string
    {
        $operationModel = new \App\Models\OperationsModel();
        $idUser = session()->get('idUtilisateur');

        // Récupère uniquement les opérations où le client est soit la source, soit le destinataire
        $data['operations'] = $operationModel->groupStart()
                                                ->where('idSource', $idUser)
                                                ->orWhere('idDestinataire', $idUser)
                                             ->groupEnd()
                                             ->findAll();

        return view('client/operations', $data);
    }
}