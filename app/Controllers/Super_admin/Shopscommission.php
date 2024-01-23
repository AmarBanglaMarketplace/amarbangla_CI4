<?php

namespace App\Controllers\Super_admin;

use App\Controllers\BaseController;
use App\Libraries\Permission;
use App\Models\AdminModel;
use App\Models\LedgernagodanModel;
use App\Models\LedgersuperModel;
use App\Models\ShopsModel;
use App\Models\SupcommiinvoiceModel;
use App\Models\SuppecommisionModel;

class Shopscommission extends BaseController
{
    protected $validation;
    protected $session;
    protected $shopsModel;
    protected $supcommiinvoiceModel;
    protected $suppecommisionModel;
    protected $adminModel;
    protected $ledgersuperModel;
    protected $ledgernagodanModel;

    protected $crop;
    protected $permission;

    public function __construct()
    {
        $this->shopsModel = new ShopsModel();
        $this->supcommiinvoiceModel = new SupcommiinvoiceModel();
        $this->suppecommisionModel = new SuppecommisionModel();
        $this->ledgersuperModel = new LedgersuperModel();
        $this->ledgernagodanModel = new LedgernagodanModel();
        $this->adminModel = new AdminModel();
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

            $data['shops'] = $this->shopsModel->findAll();

            echo view('Super_admin/header');
            echo view('Super_admin/sidebar');
            echo view('Super_admin/Shopscommission/index',$data);
            echo view('Super_admin/footer');
        }
    }

    public function unpaid_list($sch_id) {
        $isLoggedInSuperAdmin = $this->session->isLoggedInSuperAdmin;
        if (!isset($isLoggedInSuperAdmin) || $isLoggedInSuperAdmin != TRUE) {
            return redirect()->to(site_url("super_admin"));
        } else {

            $data['shopsIn'] = $this->supcommiinvoiceModel->where('sch_id',$sch_id)->where('status','0')->findAll();

            echo view('Super_admin/header');
            echo view('Super_admin/sidebar');
            echo view('Super_admin/Shopscommission/unpaid_list',$data);
            echo view('Super_admin/footer');
        }
    }

    public function paid_list($sch_id) {
        $isLoggedInSuperAdmin = $this->session->isLoggedInSuperAdmin;
        if (!isset($isLoggedInSuperAdmin) || $isLoggedInSuperAdmin != TRUE) {
            return redirect()->to(site_url("super_admin"));
        } else {

            $data['shopsIn'] = $this->supcommiinvoiceModel->where('sch_id',$sch_id)->where('status','1')->findAll();

            echo view('Super_admin/header');
            echo view('Super_admin/sidebar');
            echo view('Super_admin/Shopscommission/paid_list',$data);
            echo view('Super_admin/footer');
        }
    }

    public function pay_list($sch_id) {
        $isLoggedInSuperAdmin = $this->session->isLoggedInSuperAdmin;
        if (!isset($isLoggedInSuperAdmin) || $isLoggedInSuperAdmin != TRUE) {
            return redirect()->to(site_url("super_admin"));
        } else {

            $data['shopsIn'] = $this->supcommiinvoiceModel->where('sch_id',$sch_id)->where('status','2')->findAll();

            echo view('Super_admin/header');
            echo view('Super_admin/sidebar');
            echo view('Super_admin/Shopscommission/pay_list',$data);
            echo view('Super_admin/footer');
        }
    }

    public function cancel($invoice_id)
    {

        $sch_id = get_data_by_id('sch_id', 'sup_commi_invoice', 'invoice_id', $invoice_id);
        $shopprebal = get_data_by_id('reserve_cash', 'shops', 'sch_id', $sch_id);
        $commission = get_data_by_id('commission', 'sup_commi_invoice', 'invoice_id', $invoice_id);

        $reservTotal = $shopprebal - $commission;
        $dataReserv['sch_id'] = $sch_id;
        $dataReserv['reserve_cash'] = $reservTotal;
        $this->shopsModel->update($dataReserv['sch_id'], $dataReserv);


        $changeStatus['invoice_id'] = $invoice_id;
        $changeStatus['status'] = '0';
        $this->supcommiinvoiceModel->update($changeStatus['invoice_id'], $changeStatus);

        $this->session->setFlashdata('message', '<div class="alert alert-success alert-dismissible" role="alert">Cancel Record Success <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        return redirect()->to('super_admin/shops_commission');
    }

    public function commission_confirm()
    {
        $invoiceId = $this->request->getPost('invoiceId[]');
        $count = count($invoiceId);
        die();
        DB()->transStart();
        for ($i = 0; $i < $count; $i++) {
            $commission = get_data_by_id('commission', 'sup_commi_invoice', 'invoice_id', $invoiceId[$i]);
            $sch_id = get_data_by_id('sch_id', 'sup_commi_invoice', 'invoice_id', $invoiceId[$i]);

            // update supper_commision table
            $supcommision = get_data_by_id('commision', 'supper_commision', 'sch_id', $sch_id);
            $supcommisionpay = get_data_by_id('pay_commision', 'supper_commision', 'sch_id', $sch_id);
            $supcommisiondue = get_data_by_id('due_commision', 'supper_commision', 'sch_id', $sch_id);

            $lastpaycom = $supcommisionpay + $commission;
            $lastduecom = $supcommisiondue - $commission;


            $upsupcomdata['sch_id'] = $sch_id;
            $upsupcomdata['pay_commision'] = $lastpaycom;
            $upsupcomdata['due_commision'] = $lastduecom;
            $upsupcomdata['updatedDtm'] = date('Y-m-d h:i:s');
            $this->suppecommisionModel->update($upsupcomdata['sch_id'],$upsupcomdata);
            // update supper_commision table


            // supper admin balance update and ledger insert
            $supprebal = get_data_by_id('balance', 'admin', 'user_id', '1');
            $supnewbal = $supprebal + $commission;

            $subaldata['user_id'] = '1';
            $subaldata['balance'] = $supnewbal;
            $this->adminModel->update($subaldata['user_id'],$subaldata);


            $supledgerdata['sch_id'] = $sch_id;
            $supledgerdata['invoice_id'] = $invoiceId[$i];
            $supledgerdata['particulars'] = 'Total sale commision get';
            $supledgerdata['trangaction_type'] = 'Cr.';
            $supledgerdata['amount'] = $commission;
            $supledgerdata['rest_balance'] = $supnewbal;
            $supledgerdata['createdBy'] = '1';
            $supledgerdata['createdDtm'] = date('Y-m-d h:i:s');

            $this->ledgersuperModel->insert($supledgerdata);
            // supper admin balance update and ledger insert


            // shops balance update and ledger create
            $shopprebal = get_data_by_id('reserve_cash', 'shops', 'sch_id', $sch_id);

            $shopnewbal = $shopprebal - $commission;
            $shopupdata['sch_id'] = $sch_id;
            $shopupdata['reserve_cash'] = $shopnewbal;
            $this->shopsModel->update($shopupdata['sch_id'],$shopupdata);

            $shopBal = get_data_by_id('cash', 'shops', 'sch_id', $sch_id);
            $shopLast = $shopBal - $commission;
            $shopupcashdata['sch_id'] = $sch_id;
            $shopupcashdata['cash'] = $shopLast;
            $this->shopsModel->update($shopupcashdata['sch_id'],$shopupcashdata);



            $lgNagData['sch_id'] = $sch_id;
            $lgNagData['invoice_id'] = $invoiceId[$i];
            $lgNagData['trangaction_type'] = 'Cr.';
            $lgNagData['particulars'] = 'Super admin commision';
            $lgNagData['amount'] = $commission;
            $lgNagData['rest_balance'] = $shopLast;
            $lgNagData['createdBy'] = '1';
            $this->ledgernagodanModel->insert($lgNagData);
            // shops balance update and ledger create


            $changeStatus['invoice_id'] = $invoiceId[$i];
            $changeStatus['status'] = '1';
            $this->supcommiinvoiceModel->update($changeStatus['invoice_id'],$changeStatus);
        }

        DB()->transComplete();

        $this->session->setFlashdata('message', '<div class="alert alert-success alert-dismissible" role="alert">Create Record Success <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        return redirect()->to('super_admin/shops_commission');

    }





}
