<?php

namespace App\Controllers;
use App\Models\ConfigEpargnesModel;

class ConfigEpargnesControlleur extends BaseController
{
    public function index(){
        $idUser = session()->get('idUtilisateur');
        $conf = (new ConfigEpargnesModel())->getByUtilisateur($idUser);

        if(empty($conf)){
            $conf['pourcentage']= 0;
            $conf['idUtilisateur']=$idUser;
            $conf['idConfigEpargnes'] =0;
        }
        $data['conf'] = $conf;
        return view('client/confEpargnes',$data); 
    }

    public function save(){
        $id = $this->request->getPost('id');
        $idUtilisateur = $this->request->getPost('idUtilisateur');
        $pour = $this->request->getPost('pourcentage');
        $conf = new ConfigEpargnesModel();
        if($id==0)
            {

                $conf->update($id, [
                    'idUtilisateur' => $idUtilisateur ,
                    'pourcentage' => $pour
                ]);
            } 
        else{
            $conf->save([
                'idUtilisateur' => $idUtilisateur ,
                'pourcentage' => $pour
            ]);
        }
         return redirect()->to('/client/dashboard');
    }

}