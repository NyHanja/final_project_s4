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
            'prefixes' => $this->prefixeModel->findAll()
        ]);
    }


    public function create()
    {
        return view('admin/prefixes/create');
    }


    public function store()
    {
        $this->prefixeModel->save([
            'valeur' => $this->request->getPost('valeur'),
            'operateur' => $this->request->getPost('operateur')
        ]);

        return redirect()->to('/admin/prefixes');
    }


    public function edit($id)
    {
        return view('admin/prefixes/edit', [
            'prefixe' => $this->prefixeModel->find($id)
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