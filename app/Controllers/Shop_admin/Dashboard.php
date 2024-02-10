<?php

namespace App\Controllers\Shop_admin;

use App\Controllers\BaseController;
use App\Models\ProductsModel;
use App\Models\LoanproviderModel;
use App\Models\RolesModel;
use App\Models\SuppliersModel;
use App\Models\BankModel;
use App\Models\PurchaseModel;
use App\Models\PurchaseitemModel;
use App\Models\PackageModel;
use App\Models\ShopsModel;

class Dashboard extends BaseController
{
    protected $session;
    protected $productModel;
    protected $loanproviderModel;
    protected $suppliersModel;
    protected $bankModel;
    protected $purchaseModel;
    protected $purchaseitemModel;
    protected $packageModel;
    protected $shopsModel;
    protected $rolesModel;
    public function __construct()
    {
        $this->session = \Config\Services::session();
        $this->productModel = new ProductsModel();
        $this->loanproviderModel = new LoanproviderModel();
        $this->suppliersModel = new SuppliersModel();
        $this->bankModel = new BankModel();
        $this->purchaseModel = new PurchaseModel();
        $this->packageModel = new PackageModel();
        $this->shopsModel = new ShopsModel();
        $this->rolesModel = new RolesModel();
        $this->purchaseitemModel = new PurchaseitemModel();
    }

    private function module_permission_list($role_id, $module_name)
    {
        $result = $this->rolesModel->select('permission')->where('role_id', $role_id)->first();

        $obj = json_decode($result->permission, true);

        return $obj[$module_name];
    }

    private function have_access($roleId, $module_name, $sub_permission)
    {

        $result = $this->rolesModel->where('role_id', $roleId)->first();
        //print_r($result->permission);        	
        $obj = json_decode($result->permission, true);
        return $obj[$module_name][$sub_permission];
    }

    public function index()
    {
        $isLoggedIn = $this->session->isLoggedInShopAdmin;

        if (!isset($isLoggedIn) || $isLoggedIn != TRUE) {

            return redirect()->to(site_url("shop_admin/login"));

        } else {

            $shopId = $this->session->shopId;
            $roleId = $this->session->role;

            $totalProduct = $this->productModel->where('sch_id', $shopId)->get()->getNumRows();

            $row = $this->shopsModel->where('sch_id', $shopId)->first();

            $loanprovider = $this->loanproviderModel->select('balance')->where('sch_id', $shopId)->findAll();

            // Lone Due balance count (start) 
            $totalLoneDue = 0;
            foreach ($loanprovider as $result) {
                if ($result->balance < 0) {
                    $totalLoneDue += $result->balance;
                }
            }
            // Lone Due balance count (end) 

            //Supplier Balance  total due count (start)
            $supplier = $this->suppliersModel->select('balance')->where('sch_id', $shopId)->findAll();
            $totalsuppDue = 0;
            foreach ($supplier as $result) {
                if ($result->balance < 0) {
                    $totalsuppDue += $result->balance;
                }
            }
            //Supplier Balance  total due count (end)

            //Total All Due calculet(start)
            $totalDue = $totalLoneDue + $totalsuppDue;
            //Total All Due calculet(end)   

            //total Bank Balance calculet (start)
            $bank = $this->bankModel->selectSum('balance')->where('sch_id', $shopId)->first();
            $totalBankBal = $bank->balance;
            //total Bank Balance calculet (end)

            //purchase table null value delete (start)
            $purchId = $this->purchaseModel->where(['sch_id' => $shopId, 'due' => NULL])->findAll();
            //  var_dump($purchId);
            foreach ($purchId as $value) {
                // purchasa itame fiend count (start)
                $purItem = $this->purchaseitemModel->select('purchase_item_id')->where('purchase_id', $value->purchase_id)->get()->getNumRows();
                // purchasa itame fiend count (end)

                //deleted Nul value in purchase (start)
                if ($purItem < 1) {
                    $this->purchaseModel->where('purchase_id', $value->purchase_id)->purchaseitemModel->delete();
                }
                //deleted Nul value in purchase (end) 
            }
            //purchase table null value delete (end)

            //Total due amount calculet (start)
            $totalGet = $totalLoneDue;
            //Total due amount calculet (end)

            $invoice = $this->packageModel->where(['sch_id' => $shopId, 'status' => '0'])->first();

            if ($row) {
                $data = array(
                    'id' => $row->sch_id,
                    'name' => $row->name,
                    'address' => $row->address,
                    'totalProduct' => $totalProduct,
                    'totalDue' => $totalDue,
                    'totalGet' => $totalGet,
                    'totalBankBal' => $totalBankBal,
                    'invoiceCount' => $invoice,
                    'opening_status' => $row->opening_status,
                );
            }
            //  var_dump($invoice);
            // $perm = $this->permission->module_permission_list($role_id,role_id);
            $perm = $this->module_permission_list($roleId, 'Dashboard');

            foreach ($perm as $key => $value) {
                $data[$key] = $this->have_access($roleId, 'Dashboard', $key);
            }
            //  echo '<pre>';
            //  var_dump($data);
            //  echo '</pre>';
            echo view('Shop_admin/header');
            echo view('Shop_admin/sidebar');
            echo view('Shop_admin/dashboard', $data);
            echo view('Shop_admin/footer');
            // var_dump($data);
            // echo "</pre>";
        }
    }

    public function opening_status()
    {
        $shopId = $this->session->shopId;
        // $this->dashboard_model->get_by_id($shopId);
        // $shopId = $this->session->userdata('shopId');
        $row = $this->shopsModel->where('sch_id',$shopId)->first();
        if ($row->opening_status == 1) {
            $data = array(
                'opening_status' => '0',
            );
        } else {
            $data = array(
                'opening_status' => '1',
            );
        }
       $this->shopsModel->where('sch_id',$shopId)->update($shopId, $data);
    }
}