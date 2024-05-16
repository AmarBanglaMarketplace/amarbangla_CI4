<?php

namespace App\Controllers\Super_admin;

use App\Controllers\BaseController;
use App\Libraries\Permission;
use App\Models\LedgersuperModel;
use App\Models\ShopsModel;

class Ledger extends BaseController
{
    protected $validation;
    protected $session;
    protected $ledgersuperModel;
    protected $shopsModel;

    protected $crop;
    protected $permission;

    public function __construct()
    {
        $this->ledgersuperModel = new LedgersuperModel();
        $this->shopsModel = new ShopsModel();
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
            $data['shops'] = $this->shopsModel->where('deleted IS NULL')->findAll();

            echo view('Super_admin/header');
            echo view('Super_admin/sidebar');
            echo view('Super_admin/Ledger/index',$data);
            echo view('Super_admin/footer');
        }
    }

    public function ledger_filter(){
        $isLoggedInSuperAdmin = $this->session->isLoggedInSuperAdmin;
        if (!isset($isLoggedInSuperAdmin) || $isLoggedInSuperAdmin != TRUE) {
            return redirect()->to(site_url("super_admin"));
        } else {
            $shop = $this->request->getPost('shop');
            $st_date = $this->request->getPost('st_date');
            $en_date = $this->request->getPost('en_date');

            if ((!empty($shop)) || (!empty($st_date))) {
                if (!empty($shop)){
                    if (!empty($st_date)){
                        $data['ledger'] = $this->ledgersuperModel->where('sch_id',$shop)->where('createdDtm >=', $st_date . ' 00:00:00')->where('createdDtm <=', $en_date . ' 23:59:59')->findAll();
                    }else{
                        $data['ledger'] = $this->ledgersuperModel->where('sch_id',$shop)->findAll();
                    }
                }else {
                    $data['ledger'] = $this->ledgersuperModel->where('createdDtm >=', $st_date . ' 00:00:00')->where('createdDtm <=', $en_date . ' 23:59:59')->findAll();
                }

                $data['shops'] = $this->shopsModel->where('deleted IS NULL')->findAll();
                $data['sch_id'] = $shop;
                $data['st_date'] = $st_date;
                $data['en_date'] = $en_date;

                echo view('Super_admin/header');
                echo view('Super_admin/sidebar');
                echo view('Super_admin/Ledger/result', $data);
                echo view('Super_admin/footer');
            }else{
                $this->session->setFlashdata('message', '<div class="alert alert-danger alert-dismissible" role="alert">Sorry! Something is wrong. <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                return redirect()->to('super_admin/ledger');
            }
        }
    }







}
