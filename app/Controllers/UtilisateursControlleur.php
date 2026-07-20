<?php

namespace App\Controllers;

use App\Models\PrefixeModel;
use App\Models\UtilisateursModel;

class UtilisateursControlleur extends BaseController
{
    public function index(): string
    {
        return view('utilisateurs/index');
    }

    public function login()
    {
        if ($this->request->getMethod() === 'POST') {
            $numeroTelephone = trim((string) $this->request->getPost('numeroTelephone'));

            if (empty($numeroTelephone)) {
                return view('utilisateurs/index', ['error' => 'Veuillez entrer votre numéro de téléphone.']);
            }

            $prefixeModel = new PrefixeModel();
            if (!$prefixeModel->validationPrefixes($numeroTelephone)) {
                return view('utilisateurs/index', ['error' => 'Numéro de téléphone invalide.']);
            }

            $utilisateurModel = new UtilisateursModel();
            $utilisateur = $utilisateurModel->where('numeroTelephone', $numeroTelephone)->first();

            if ($utilisateur) {
                $session = session();
                $session->set([
                    'idUtilisateur'   => $utilisateur['idUtilisateurs'],
                    'numeroTelephone' => $utilisateur['numeroTelephone'],
                    'idRoles'         => $utilisateur['idRoles'],
                    'isLoggedIn'      => true,
                ]);

                if ((int) $utilisateur['idRoles'] === 1) {
                    return view('admin/dashboard');
                }

                return view('client/dashboard');
            }

            return view('utilisateurs/index', ['error' => 'Numéro de téléphone non trouvé.']);
        }

        return view('utilisateurs/index');
    }
}
