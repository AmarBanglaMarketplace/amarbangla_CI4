<?php

namespace App\Controllers\Super_admin;

use App\Controllers\BaseController;
use App\Libraries\Permission;
use App\Models\CallingrequestModel;

class Callingrequest extends BaseController
{
    protected $validation;
    protected $session;
    protected $callingrequestModel;

    protected $crop;
    protected $permission;

    public function __construct()
    {
        $this->callingrequestModel = new CallingrequestModel();
        $this->validation = \Config\Services::validation();
        $this->session = \Config\Services::session();
        $this->permission = new Permission();
        $this->crop = \Config\Services::image();
    }
    public function index() {
        $isLoggedInSuperAdmin = $this->session->isLoggedInSuperAdmin;
        if (!isset($isLoggedInSuperAdmin) || $isLoggedInSuperAdmin != TRUE) {
            return redirect()->to(site_url("super_admin"));
        } else {

            $data['calling'] = $this->callingrequestModel->findAll();

            echo view('Super_admin/header');
            echo view('Super_admin/sidebar');
            echo view('Super_admin/Callingrequest/index',$data);
            echo view('Super_admin/footer');
        }
    }

    public function status_update(){

        $data['calling_id'] = $this->request->getPost('calling_id');
        $data['status'] = $this->request->getPost('status');
        $this->callingrequestModel->update($data['calling_id'], $data);

        print '<div class="alert alert-success alert-dismissible" role="alert">Update Record Success <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
    }







}
