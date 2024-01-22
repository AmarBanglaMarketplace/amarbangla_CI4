<?php

namespace App\Controllers\Super_admin;

use App\Controllers\BaseController;
use App\Libraries\Permission;
use App\Models\InvoiceitemModel;
use App\Models\InvoiceModel;
use App\Models\LedgerModel;

class Order extends BaseController
{
    protected $validation;
    protected $session;
    protected $invoiceModel;
    protected $invoiceitemModel;
    protected $ledgerModel;

    protected $crop;
    protected $permission;

    public function __construct()
    {
        $this->invoiceModel = new InvoiceModel();
        $this->invoiceitemModel = new InvoiceitemModel();
        $this->ledgerModel = new LedgerModel();
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

            $data['order'] = $this->invoiceModel->findAll();

            echo view('Super_admin/header');
            echo view('Super_admin/sidebar');
            echo view('Super_admin/Order/index',$data);
            echo view('Super_admin/footer');
        }
    }
    public function invoice($invoice_id) {
        $isLoggedInSuperAdmin = $this->session->isLoggedInSuperAdmin;
        if (!isset($isLoggedInSuperAdmin) || $isLoggedInSuperAdmin != TRUE) {
            return redirect()->to(site_url("super_admin"));
        } else {


            $data['shopsName'] = 'Amer bangla bazar';
            $data['invoiceId'] = $invoice_id;

            $data['invoiceItame'] = $this->invoiceitemModel->where('invoice_id',$invoice_id)->findAll();


            //due calculation (start)
            $invoiceDue = $this->invoiceModel->select('due')->where('invoice_id',$invoice_id)->first()->due;


            $rest_balance_query = $this->ledgerModel->select('rest_balance')->where('invoice_id',$invoice_id)->where('trangaction_type','Cr.')->first();

            if (!empty($rest_balance_query)) {
                $rest_balance = $rest_balance_query->rest_balance;
            }else {
                $rest_balance = 0;
            }


            $amount_query = $this->ledgerModel->select('amount')->where('invoice_id',$invoice_id)->where('trangaction_type','Cr.')->first();
            if (!empty($amount_query)) {
                $amount = $amount_query->amount;
            }else {
                $amount = 0;
            }



            $data['oldDue'] = $rest_balance - $amount;
            $data['totalDue'] = $invoiceDue;
            //due calculation (end)

            $data['customerId'] = get_data_by_id('customer_id','invoice','invoice_id',$invoice_id);

            echo view('Super_admin/header');
            echo view('Super_admin/sidebar');
            echo view('Super_admin/Order/invoice',$data);
            echo view('Super_admin/footer');
        }
    }







}
