<?php

namespace App\Controllers\Super_admin;

use App\Controllers\BaseController;
use App\Libraries\Permission;
use App\Models\GlobaladdressModel;


class Globaladdress extends BaseController
{
    protected $validation;
    protected $session;
    protected $globaladdressModel;

    protected $crop;
    protected $permission;

    public function __construct(){
        $this->globaladdressModel = new GlobaladdressModel();
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

            $data['address_data'] = $this->globaladdressModel->findAll();

            echo view('Super_admin/header');
            echo view('Super_admin/sidebar');
            echo view('Super_admin/Globaladdress/index',$data);
            echo view('Super_admin/footer');
        }
    }

    public function create() {
        $isLoggedInSuperAdmin = $this->session->isLoggedInSuperAdmin;
        if (!isset($isLoggedInSuperAdmin) || $isLoggedInSuperAdmin != TRUE) {
            return redirect()->to(site_url("super_admin"));
        } else {


            echo view('Super_admin/header');
            echo view('Super_admin/sidebar');
            echo view('Super_admin/Globaladdress/create');
            echo view('Super_admin/footer');
        }
    }







}
