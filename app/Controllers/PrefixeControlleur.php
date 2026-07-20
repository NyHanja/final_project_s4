<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PrefixeModel;

class PrefixeControlleur extends BaseController
{
    protected $prefixeModel;

    public function __construct()
    {
        $this->prefixeModel = new PrefixeModel();
    }


    public function index()
    {
        return view('admin/prefixes/index', [
            'prefixes' => $this->prefixeModel->listeWithOperateurs()
        ]);
    }


    public function create()
    {
        $operateursModel = new \App\Models\OperateursModel();
        return view('admin/prefixes/create', [
            'operateurs' => $operateursModel->findAll()
        ]);
    }


    public function store()
    {
        $this->prefixeModel->save([
            'valeur' => $this->request->getPost('valeur'),
            'idOperateurs' => $this->request->getPost('idOperateurs')
        ]);

        return redirect()->to('/admin/prefixes');
    }


    public function edit($id)
    {
        $operateursModel = new \App\Models\OperateursModel();
        return view('admin/prefixes/edit', [
            'prefixe' => $this->prefixeModel->select('prefixes.*, operateurs.nom as operateur')
                                            ->join('operateurs', 'prefixes.idOperateurs = operateurs.idOperateurs', 'left')
                                            ->find($id),
            'operateurs' => $operateursModel->findAll()
        ]);
    }


    public function update($id)
    {
        $this->prefixeModel->update($id, [
            'valeur' => $this->request->getPost('valeur'),
            'operateur' => $this->request->getPost('operateur')
        ]);

        return redirect()->to('/admin/prefixes');
    }


    public function delete($id)
    {
        $this->prefixeModel->delete($id);

        return redirect()->to('/admin/prefixes');
    }
}