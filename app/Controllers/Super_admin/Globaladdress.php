<?php

namespace App\Controllers\Super_admin;

use App\Controllers\BaseController;
use App\Libraries\Permission;
use App\Models\LedgersuperModel;

class Globaladdress extends BaseController
{
    protected $validation;
    protected $session;
    protected $ledgersuperModel;

    protected $crop;
    protected $permission;

    public function __construct(){
        $this->ledgersuperModel = new LedgersuperModel();
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

            $data['ledger'] = $this->ledgersuperModel->findAll();

            echo view('Super_admin/header');
            echo view('Super_admin/sidebar');
            echo view('Super_admin/Ledger/index',$data);
            echo view('Super_admin/footer');
        }
    }







}
