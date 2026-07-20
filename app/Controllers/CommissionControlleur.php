git pull origin dev<?php

namespace App\Controllers;


use App\Controllers\BaseController;
use App\Models\CommissionModel;
use App\Models\OperateursModel;


class CommissionControlleur extends BaseController
{


    protected $commissionModel;
    protected $operateurModel;



    public function __construct()
    {
        $this->commissionModel = new CommissionModel();
        $this->operateurModel = new OperateursModel();
    }



    public function index()
    {

        return view('admin/commisions/index', [

            'commissions' => $this->commissionModel->listeCommissions()

        ]);

    }




    public function create()
    {

        return view('admin/commisions/create', [

            'operateurs' => $this->operateurModel->findAll()

        ]);

    }




    public function store()
    {

        $this->commissionModel->save([

            'pourcentage' => $this->request->getPost('pourcentage'),

            'idOperateurs' => $this->request->getPost('idOperateurs')

        ]);


        return redirect()->to('/admin/commisions');

    }




    public function edit($id)
    {

        return view('admin/commisions/edit', [

            'commission' => $this->commissionModel->find($id),

            'operateurs' => $this->operateurModel->findAll()

        ]);

    }





    public function update($id)
    {

        $this->commissionModel->update($id, [

            'pourcentage' => $this->request->getPost('pourcentage'),

            'idOperateurs' => $this->request->getPost('idOperateurs')

        ]);


        return redirect()->to('/admin/commisions');

    }





    public function delete($id)
    {

        $this->commissionModel->delete($id);

        return redirect()->to('/admin/commisions');

    }


}