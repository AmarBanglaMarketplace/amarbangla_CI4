<?php

namespace App\Controllers\Shop_admin;

use App\Controllers\BaseController;
use App\Libraries\Permission;
use App\Models\InvoiceitemModel;
use App\Models\PackageModel;

class Invoice extends BaseController
{
    protected $session;
    protected $validation;
    protected $permission;
    protected $packageModel;
    protected $invoiceitemModel;
    private $module_name = 'Invoice';
    public function __construct()
    {
        $this->packageModel = new PackageModel();
        $this->invoiceitemModel = new InvoiceitemModel();
        $this->session = \Config\Services::session();
        $this->validation = \Config\Services::validation();
        $this->permission = new permission();
    }

    public function index(){


        $data['package'] = $this->packageModel->where('sch_id',Auth()->sch_id)->orderBy('package_id','DESC')->findAll();

        $permi = $this->permission->module_permission(Auth()->role_id, $this->module_name);
        if (isset($permi['mod_access']) and $permi['mod_access'] == 1) {
            echo view('Shop_admin/Invoice/index', $data);
        }else{
            echo view('Shop_admin/no_permission');
        }


    }
    public function view($package_id){


        $query = $this->packageModel->where('package_id',$package_id)->first();

        $data['invoiceId'] = $query->invoice_id;
        $data['customerId'] = get_data_by_id('customer_id', 'invoice', 'invoice_id', $query->invoice_id);

        $data['package'] = $package_id;
        $data['subtotal'] = $query->price;
        $data['delCharge'] = $query->delivery_charge;
        $data['finalAmount'] = $query->price + $query->delivery_charge;
        $data['dueAmount'] = $query->price + $query->delivery_charge;
        $data['createdDtm'] = $query->createdDtm;
        $data['status'] = $query->status;
        $data['shopsName'] = Auth()->shopName;

        $data['invoiceItem'] = $this->invoiceitemModel->where('package_id', $package_id)->findAll();

        $permi = $this->permission->module_permission(Auth()->role_id, $this->module_name);
        if (isset($permi['mod_access']) and $permi['mod_access'] == 1) {
            echo view('Shop_admin/Invoice/view', $data);
        }else{
            echo view('Shop_admin/no_permission');
        }


    }

    public function package_action($package_id){
        $data['invoice_data'] = $this->invoiceitemModel->where('package_id', $package_id)->findAll();

        $query = $this->invoiceitemModel->selectSum('total_price')->where('package_id', $package_id)->first();

        $deliveryCharge = get_data_by_id('delivery_charge', 'package', 'package_id', $package_id);

        $data['total'] = $query->total_price + $deliveryCharge;
        $data['delCharge'] = $deliveryCharge;
        $data['packageId'] = $package_id;

        $data['invoiceId'] = get_data_by_id('invoice_id', 'package', 'package_id', $package_id);

        $permi = $this->permission->module_permission(Auth()->role_id, $this->module_name);
        if (isset($permi['mod_access']) and $permi['mod_access'] == 1) {
            echo view('Shop_admin/Invoice/paid', $data);
        }else{
            echo view('Shop_admin/no_permission');
        }
    }

    public function package_create_action(){
        $customerId = $this->request->getPost('customer_id', TRUE);

        $proId = $this->request->getPost('productId[]', TRUE);
        $quantity = $this->request->getPost('qty[]', TRUE);
        $proPrice = $this->request->getPost('price[]', TRUE);
        $prodsaleDisc = $this->request->getPost('disc[]', TRUE);
        $prodsubtotal = $this->request->getPost('subtotal[]', TRUE);
        $prosubTo = $this->request->getPost('suballtotal[]', TRUE);

        $entiresaleDisc = $this->request->getPost('saleDisc', TRUE);
        $vat = $this->request->getPost('vat', TRUE);
        $vatAmount = $this->request->getPost('vatAmount', TRUE);


        $amount = $this->request->getPost('grandtotal2', TRUE);
        $finalAmount = $this->request->getPost('grandtotal', TRUE);

        $nagod = $this->request->getPost('nagod', TRUE);
        $bankAmount = $this->request->getPost('bankAmount', TRUE);
        $bankId = $this->request->getPost('bank_id', TRUE);
        $chequeNo = $this->request->getPost('chequeNo', TRUE);
        $chequeAmount = $this->request->getPost('chequeAmount', TRUE);

        $dueAmount = $this->request->getPost('grandtotaldue', TRUE);

        $packageId = $this->request->getPost('package_id', TRUE);

        $invoiceId = get_data_by_id('invoice_id', 'package', 'package_id', $packageId);

        $checkSeller = checkSellerInvoice($invoiceId);

        $checkDeliveryBoy = checkDeliveryBoyInvoice($invoiceId);

        $delChar = get_data_by_id('delivery_charge', 'package', 'package_id', $packageId);

        $totalsell = $finalAmount - $delChar;


        if ($delChar == NULL) {
            $this->session->set_flashdata('message', '<div style="margin-top: 12px" class="alert alert-danger" id="message">Please update delivery charge!! </div>');
            redirect(site_url('invoice/read/' . $packageId));
        } else {

            $this->db->trans_start();
            $finalCommission = 0;
            //invoice itame insert
            $number = count($proId);
            for ($i = 0; $i < $number; $i++) {

                $checkpurType = purchaseTypeCheck($proId[$i]);

                if ($checkpurType == true) {
                    $supplierId = get_data_by_id('supplier_id', 'products', 'prod_id', $proId[$i]);

                    $purchData = array(
                        'sch_id' => $shopId,
                        'supplier_id' => $supplierId,
                        'amount' => $prodsubtotal[$i],
                        'due' => $prodsubtotal[$i],
                    );
                    $this->db->insert('purchase', $purchData);
                    $purcheId = $this->db->insert_id();


                    $purchPrice = get_data_by_id('purchase_price', 'products', 'prod_id', $proId[$i]);
                    $totalPurPrice = $purchPrice * $quantity[$i];

                    $purchItemData = array(
                        'purchase_id' => $purcheId,
                        'prod_id' => $proId[$i],
                        'purchase_price' => $purchPrice,
                        'quantity' => $quantity[$i],
                        'total_price' => $totalPurPrice,
                    );
                    $this->db->insert('purchase_item', $purchItemData);


                    $supplierBalance = get_data_by_id('balance', 'suppliers', 'supplier_id', $supplierId);
                    $suppNewCash = $supplierBalance - $totalPurPrice;

                    $suppData = array(
                        'balance' => $suppNewCash,
                        'updatedBy' => $userId,
                    );
                    $this->db->where('supplier_id', $supplierId);
                    $this->db->update('suppliers', $suppData);

                    //create suppliers ledger
                    $lgSuplData = array(
                        'sch_id' => $shopId,
                        'supplier_id' => $supplierId,
                        'purchase_id' => $purcheId,
                        'trangaction_type' => 'Dr.',
                        'particulars' => 'Purchase Cash Due',
                        'amount' => $totalPurPrice,
                        'rest_balance' => $suppNewCash,
                        'createdBy' => $userId,
                        'createdDtm' => date('Y-m-d h:i:s'),
                    );
                    $this->db->insert('ledger_suppliers', $lgSuplData);
                } else {
                    //product Qnt Update in product table (start)
                    $productQnt = get_data_by_id('quantity', 'products', 'prod_id', $proId[$i]);
                    $qnt = $productQnt - $quantity[$i];
                    $qntProData = array(
                        'quantity' => $qnt,
                        'updatedBy' => $userId,
                    );

                    $this->db->where('prod_id', $proId[$i]);
                    $this->db->update('products', $qntProData);
                    //product Qnt Update in product table (end)
                }


                //calculating profit for indivisual item and updating the profite column (start)
                $productPurPrice = get_data_by_id('purchase_price', 'products', 'prod_id', $proId[$i]);
                $purPrice = $productPurPrice * $quantity[$i];
                $profit = $prosubTo[$i] - $purPrice;
                $profitData = array('profit' => $profit);

                $where = array(
                    'package_id' => $packageId,
                    'prod_id' => $proId[$i],
                );
                $this->db->where($where);
                $this->db->update('invoice_item', $profitData);
                //calculating profit for indivisual item and updating the profite column (end)


                // seller balance update(start)
                if ($checkSeller == TRUE) {

                    $sellerId = get_data_by_id('seller_id', 'invoice', 'invoice_id', $invoiceId);

                    $sellerBallance = get_data_by_id('balance', 'seller', 'seller_id', $sellerId);

                    $procommission = get_data_by_id('seller_commission', 'products', 'prod_id', $proId[$i]);

                    $commission = ($prodsubtotal[$i] * $procommission) / 100;
                    $finalCommission += $commission;

                    $sellerRestBalance = $sellerBallance - $commission;

                    $databalSeller = array('balance' => $sellerRestBalance,);

                    $this->db->where('seller_id', $sellerId);
                    $this->db->update('seller', $databalSeller);


                    $sellerLedger = array(
                        'sch_id' => $shopId,
                        'seller_id' => $sellerId,
                        'invoice_id' => $invoiceId,
                        'package_id' => $packageId,
                        'trangaction_type' => 'Dr.',
                        'particulars' => 'Sales commission',
                        'amount' => $commission,
                        'rest_balance' => $sellerRestBalance,
                        'createdBy' => $userId,
                        'createdDtm' => date('Y-m-d h:i:s')
                    );
                    $this->db->insert('ledger_seller', $sellerLedger);

                }
                //seller balance update(end)

            }


            if ($checkSeller == TRUE) {
                $commissionData = array(
                    'invoice_id' => $invoiceId,
                    'package_id' => $packageId,
                    'seller_id' => $sellerId,
                    'commission' => $finalCommission,
                    'createdBy' => $userId,
                    'createdDtm' => date('Y-m-d h:i:s')
                );
                $this->db->insert('commission', $commissionData);
            }

            $checkDelivery = $this->db->get_where('delivery', array('package_id' => $packageId))->num_rows();
            if (!empty($checkDelivery)) {
                $deliveryboyId = get_data_by_id('delivery_boy_id', 'delivery', 'package_id', $packageId);
                if (!empty($deliveryboyId)) {

                    $delBoyCharge = get_data_by_id('delivery_charge', 'package', 'package_id', $packageId);


                    // delivery Balance updata
                    $shopsdelBal = get_data_by_id('del_balance', 'shops', 'sch_id', $shopId);
                    $restDelBalanceShop = $shopsdelBal + $delBoyCharge;
                    $updelbalanceShop = array(
                        'del_balance' => $restDelBalanceShop,
                    );

                    $this->db->where('sch_id', $shopId)->update('shops', $updelbalanceShop);


                    // delivery Balance ledger insert
                    $delivery_BalLedger = array(
                        'sch_id' => $shopId,
                        'delivery_boy_id' => $deliveryboyId,
                        'invoice_id' => $invoiceId,
                        'package_id' => $packageId,
                        'trangaction_type' => 'Dr.',
                        'particulars' => 'Delivery charge',
                        'amount' => $delBoyCharge,
                        'rest_balance' => $restDelBalanceShop,
                        'createdBy' => $userId,
                        'createdDtm' => date('Y-m-d h:i:s')
                    );
                    $this->db->insert('ledger_delivery_balance', $delivery_BalLedger);


                    //delivery boy balance update
                    $delBoyChargefinal = (80 * $delBoyCharge) / 100;
                    $delboyprevBal = get_data_by_id('balance', 'delivery_boy', 'delivery_boy_id', $deliveryboyId);

                    $restDelBalance = $delboyprevBal - $delBoyChargefinal;

                    $upDelBalrest = array('balance' => $restDelBalance);
                    $this->db->where('delivery_boy_id', $deliveryboyId);
                    $this->db->update('delivery_boy', $upDelBalrest);


                    //delivery boy ledger insert
                    $delivery_boyLedger = array(
                        'sch_id' => $shopId,
                        'delivery_boy_id' => $deliveryboyId,
                        'invoice_id' => $invoiceId,
                        'package_id' => $packageId,
                        'trangaction_type' => 'Dr.',
                        'particulars' => 'Delivery charge',
                        'amount' => $delBoyChargefinal,
                        'rest_balance' => $restDelBalance,
                        'createdBy' => $userId,
                        'createdDtm' => date('Y-m-d h:i:s')
                    );
                    $this->db->insert('ledger_delivery_boy', $delivery_boyLedger);


                    //delivery boy commission insert
                    $delBoycommissionData = array(
                        'invoice_id' => $invoiceId,
                        'package_id' => $packageId,
                        'delivery_boy_id' => $deliveryboyId,
                        'commission' => $delBoyChargefinal,
                        'createdBy' => $userId,
                        'createdDtm' => date('Y-m-d h:i:s')
                    );
                    $this->db->insert('commission', $delBoycommissionData);
                }
            } else {
                $delivData = array(
                    'sch_id' => $shopId,
                    'invoice_id' => $invoiceId,
                    'package_id' => $packageId,
                    'status' => '1',
                    'accepetDtm' => date('Y-m-d h:i:s'),
                    'createdDtm' => date('Y-m-d h:i:s'),
                    'createdBy' => $shopId,
                );
                $this->db->insert('delivery', $delivData);
            }

            // update delivery status
            $upStatusDel = array('status' => '1');
            $this->db->where('package_id', $packageId);
            $this->db->update('delivery', $upStatusDel);


            //Update salse profit,status,due in invoice table (start)
            $totalProfit = $this->db->select_sum('profit')->from('invoice_item')->where('package_id', $packageId)->get()->row()->profit;
            $inData = array(
                'profit' => $totalProfit,
                'updatedBy' => $userId,
                'status' => '1',
            );
            $this->db->where('package_id', $packageId);
            $this->db->update('package', $inData);
            //Update salse profit,status,due in invoice table (end)


            // total sale amount
            $sup_comm = get_data_by_id('sup_comm', 'shops', 'sch_id', $shopId);

            // supper commission  invoice (start)
            $supCom = ($totalsell * $sup_comm) / 100;
            $supperCommData = array(
                'invoice_id' => $invoiceId,
                'package_id' => $packageId,
                'sch_id' => $shopId,
                'percent' => $sup_comm,
                'amount' => $totalsell,
                'commission' => $supCom,
                'status' => '0',
                'createdDtm' => date('Y-m-d h:i:s'),
                'createdBy' => $userId,
            );
            $this->db->insert('sup_commi_invoice', $supperCommData);

            // supper commission invoice (end)


            // supper commission update(start)
            $supCommision = get_data_by_id('commision', 'supper_commision', 'sch_id', $shopId);
            $selcommiSuperad = $supCommision + $supCom;

            $due_commision = get_data_by_id('due_commision', 'supper_commision', 'sch_id', $shopId);
            $totalduecommision = $due_commision + $supCom;

            $selcomData = array(
                'commision' => $selcommiSuperad,
                'due_commision' => $totalduecommision,
                'updatedDtm' => date('Y-m-d h:i:s')
            );
            $this->db->where('sch_id', $shopId);
            $this->db->update('supper_commision', $selcomData);
            //supper commission update(end)


            // total sale amount


            //create sals in sales table(start)
            $saleData = array(
                'sch_id' => $shopId,
                'invoice_id' => $invoiceId,
                'package_id' => $packageId
            );
            $this->db->insert('sales', $saleData);
            //create sals in sales table(end)


            //customer balance update in customer table (start)
            $customerCash = get_data_by_id('balance', 'customers', 'customer_id', $customerId);
            $newCash = $customerCash + $finalAmount;
            //update balance
            $custData = array(
                'balance' => $newCash,
                'updatedBy' => $userId,
            );
            $this->db->where('customer_id', $customerId);
            $this->db->update('customers', $custData);
            //customer balance update in customer table (end)


            // //insert customer ledger in ledger(start)
            $ledgerData = array(
                'sch_id' => $shopId,
                'customer_id' => $customerId,
                'invoice_id' => $invoiceId,
                'package_id' => $packageId,
                'trangaction_type' => 'Cr.',
                'particulars' => 'Sales Cash Due',
                'amount' => $finalAmount,
                'rest_balance' => $newCash,
                'createdBy' => $userId,
            );
            $this->db->insert('ledger', $ledgerData);
            //insert customer ledger in ledger(end)


            //cash pay shop cash update and create nagod ledger (start)
            if ($nagod > 0) {
                //cash pay amount update shops cash (start)
                $shopsCash = get_data_by_id('cash', 'shops', 'sch_id', $shopId);
                $upCahs = $shopsCash + $nagod;

                $shopsData = array(
                    'cash' => $upCahs,
                    'updatedBy' => $userId,
                );
                $this->db->where('sch_id', $shopId);
                $this->db->update('shops', $shopsData);
                //cash pay amount update shops cash (end)


                //insert ledger in ledger_nagodan cash pay amount(start)
                $lgNagData = array(
                    'sch_id' => $shopId,
                    'invoice_id' => $invoiceId,
                    'package_id' => $packageId,
                    'trangaction_type' => 'Dr.',
                    'particulars' => 'Sales Cash Pay',
                    'amount' => $nagod,
                    'rest_balance' => $upCahs,
                    'createdBy' => $userId,
                );
                $this->db->insert('ledger_nagodan', $lgNagData);
                //     //insert ledger in ledger_nagodan cash pay amount(start)


                //cash pay amount and customer balance amount calculate and update customer balance (start)
                if ($customerId) {
                    //customer balance calculate (start)
                    $custCash = get_data_by_id('balance', 'customers', 'customer_id', $customerId);
                    $newcastCash = $custCash - $nagod;
                    //customer balance calculate (end)


                    //update calculate balance in customer table(start)
                    $custnewData = array(
                        'balance' => $newcastCash,
                        'updatedBy' => $userId,
                    );
                    $this->db->where('customer_id', $customerId);
                    $this->db->update('customers', $custnewData);
                    //update calculate balance in customer table(end)


                    //create ledger in ledger table
                    $ledgernogodData = array(
                        'sch_id' => $shopId,
                        'customer_id' => $customerId,
                        'invoice_id' => $invoiceId,
                        'package_id' => $packageId,
                        'trangaction_type' => 'Dr.',
                        'particulars' => 'Sales Cash Pay',
                        'amount' => $nagod,
                        'rest_balance' => $newcastCash,
                        'createdBy' => $userId,
                    );
                    $this->db->insert('ledger', $ledgernogodData);
                }
                //cash pay amount and customer balance amount calculate and update customer balance (end)
            }
            //cash pay shop cash update and create nagod ledger (end)


            // bank pay amount calculate and bank balance update (start)
            if ($bankAmount > 0) {
                //bank pay amount calculate and update bank balance (start)
                $bankCash = get_data_by_id('balance', 'bank', 'bank_id', $bankId);
                $upCahs = $bankCash + $bankAmount;

                $bankData = array(
                    'balance' => $upCahs,
                    'updatedBy' => $userId,
                );
                $this->db->where('bank_id', $bankId);
                $this->db->update('bank', $bankData);
                //bank pay amount calculate and update bank balance (end)


                //insert ledger in table ledger_bank (start)
                $lgBankData = array(
                    'sch_id' => $shopId,
                    'bank_id' => $bankId,
                    'invoice_id' => $invoiceId,
                    'package_id' => $packageId,
                    'particulars' => 'Sales Bank Pay',
                    'trangaction_type' => 'Dr.',
                    'amount' => $bankAmount,
                    'rest_balance' => $upCahs,
                    'createdBy' => $userId,
                );
                $this->db->insert('ledger_bank', $lgBankData);
                //insert ledger in table ledger_bank (end)


                if ($customerId) {
                    //bank pay amount calculate and customer balance update (start)
                    $cusCash = get_data_by_id('balance', 'customers', 'customer_id', $customerId);
                    $bankastCash = $cusCash - $bankAmount;

                    $custnewData = array(
                        'balance' => $bankastCash,
                        'updatedBy' => $userId,
                    );
                    $this->db->where('customer_id', $customerId);
                    $this->db->update('customers', $custnewData);
                    //bank pay amount calculate and customer balance update (start)


                    //insert ledger in table ledger (start)
                    $ledgerbankData = array(
                        'sch_id' => $shopId,
                        'customer_id' => $customerId,
                        'invoice_id' => $invoiceId,
                        'package_id' => $packageId,
                        'trangaction_type' => 'Dr.',
                        'particulars' => 'Sales Bank Pay',
                        'amount' => $bankAmount,
                        'rest_balance' => $bankastCash,
                        'createdBy' => $userId,
                    );
                    $this->db->insert('ledger', $ledgerbankData);
                    //insert ledger in table ledger (start)

                }

            }
            // bank pay amount calculate and bank balance update (end)


            // invoice status change
            $chInvSt = $this->invoice_package_status_check($invoiceId,$packageId);
            if ($chInvSt == true){
                $invData = array(
                    'status'=>'1'
                );
                $this->db->where('invoice_id',$invoiceId)->update('invoice',$invData);
            }
            // invoice status change


            $this->db->trans_complete();


            $this->session->set_flashdata('message', '<div style="margin-top: 12px" class="alert alert-success" id="message">Your invoice was paid successfully</div>');
            redirect(site_url('invoice'));
        }
    }









}