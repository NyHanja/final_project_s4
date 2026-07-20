<?php

namespace App\Controllers;

class UtilisateursControlleur extends BaseController
{
    public function index(): string
    {
        return view('utilisateurs/index');
    }

    public function login(): string
    {
        if ($this->request->getMethod() === 'POST') {
            $numeroTelephone = $this->request->getPost('numeroTelephone');
            // $motDePasse = $this->request->getPost('motDePasse');
            if (empty($numeroTelephone)) {
                return view('utilisateurs/login', ['error' => 'Veuillez entrer votre numéro de téléphone.']);
            }
            $prefixeModel = new \App\Models\PrefixeModel();
            if (!$prefixeModel->validationPrefixes($numeroTelephone)) {
                return view('utilisateurs/login', ['error' => 'Numéro de téléphone invalide.']);
            } else {
                $utilisateurModel = new \App\Models\UtilisateursModel();
                $utilisateur = $utilisateurModel->where('numeroTelephone', $numeroTelephone)->first();
                if ($utilisateur) {
                    $session = session();
                    $session->set([
                        'idUtilisateur' => $utilisateur['idUtilisateurs'],
                        'numeroTelephone' => $utilisateur['numeroTelephone'],
                        'idRoles' => $utilisateur['idRoles'], 
                        'isLoggedIn' => true
                    ]);
                    if($utilisateur['idRoles'] == 1){
                        return view('admin/dashboard');
                    } 
                    else{
                        return view('client/dashboard');
                    }
                } else {
                    return view('utilisateurs/index', ['error' => 'Numéro de téléphone non trouvé.']);
                }
            }

        }
    }


}
