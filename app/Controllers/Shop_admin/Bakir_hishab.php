<?php
namespace App\Controllers\Shop_admin;

use App\Models\LedgernagodanModel;
use CodeIgniter\Files\File;
use App\Models\LedgerloanModel;
use App\Controllers\BaseController;
use App\Models\RolesModel;
use App\Models\ChaqueModel;
use App\Models\TransactionModel;
use App\Models\BankModel;
use App\Models\LedgerbankModel;
use App\Models\LoanproviderModel;
use App\Models\ShopsModel;
use App\Libraries\Permission;

class Bakir_hishab extends BaseController
{
    protected $validation;
    private $session;
    private $rolesModel;
    private $chaqueModel;
    private $transactionModel;
    private $ledgerloanModel;
    private $bankModel;
    private $ledgerbankModel;
    private $loanproviderModel;
    private $shopsModel;
    private $ledgernagodanModel;
    private $permission;
    public function __construct()
    {
        $this->shopsModel = new ShopsModel();
        $this->validation = \Config\Services::validation();
        $this->session = \Config\Services::session();
        $this->rolesModel = new RolesModel();
        $this->chaqueModel = new ChaqueModel();
        $this->transactionModel = new TransactionModel();
        $this->ledgerloanModel = new LedgerloanModel();
        $this->BankModel = new BankModel();
        $this->ledgerbankModel = new LedgerbankModel();
        $this->loanproviderModel = new LoanproviderModel();
        $this->ledgernagodanModel = new LedgernagodanModel();
        $this->permission = new Permission();
    }

    public function index()
    {

    }

    public function create()
    {


            $perm = $this->permission->module_permission_list($role, 'Transaction');
            foreach ($perm as $key => $val) {
                $data[$key] = $this->permission->have_access($role, 'Transaction', $key);
            }

            // var_dump($data);
            echo view('Shop_admin/header');
            echo view('Shop_admin/sidebar');
            echo view('Shop_admin/Bakir_hishab/create', $data);
            echo view('Shop_admin/footer');

    }

    public function create_action()
    {
        
        $userId = $this->session->userId;
        $shopId = $this->session->shopId;
        $amount = str_replace(',', '', $this->request->getPost('amount'));
        $loanProId = $this->request->getPost('loan_pro_id');
      
        //loan_pro Balance
        $loanProBalance = get_data_by_id('balance', 'loan_provider', 'loan_pro_id', $loanProId);
        $restBalance = $loanProBalance + $amount;
        $restBalanceDr = $loanProBalance - $amount;

        //Payment Type
        $paymentType = $this->request->getPost('payment_type');
        
        //shop data
        $shopBalance = get_data_by_id('cash', 'shops', 'sch_id', $shopId);
        $shopUpdateBalance = $shopBalance - $amount;
        $shopUpdateBalanceCr = $shopBalance + $amount;

        $trangactionType = $this->request->getPost('trangaction_type');

        $chequeNo = $this->request->getPost('chequeNo');
        $chequeAmount = $this->request->getPost('chequeAmount');
       
        if ($paymentType == 1) {
            $bankId = $this->request->getPost('bank_id');
            if ($bankId) {
                $bankCash = get_data_by_id('balance', 'bank', 'bank_id', $bankId);
                $bankUpData = $bankCash - $amount;
                $bankUpDataCr = $bankCash + $amount;
            }
            $availableBalance = checkBankBalance($bankId, $amount);
        }
        if ($paymentType == 2) {
            $availableBalance = checkNagadBalance($amount);
        }


        (!empty($this->request->getPost('amount'))) ? $amounts = 'amount' : $amounts = 'chequeAmount';
       
        $this->validation->setRule($amounts, $amounts, 'trim|required|is_natural_no_zero'); 

        if ($this->validation->withRequest($this->request)->run() == FALSE) {
             return redirect()->to(site_url('shop_admin/bakir_hishab/create'));
        } else {

            //sms setting(start)
            $smsType = ($trangactionType == 1) ? 'খরচ' : 'জমা';
            $smsMessage = 'AmarBangla ' . profile_name() . ' ' . $this->request->getPost('particulars') . ' ' . $amount;
            $masLength = strlen($smsMessage);
            $sendSms = '<span style="color: red;">আপনার একাউন্টে কোন মেসেজ জমা নাই । মেসেজের জন্য রিকোয়েস্ট করুন।</span>';
            $totalSmsSend = 0;
            $x = 0;
            while ($x <= $masLength) {
                $x += 61;
                $totalSmsSend += 1;
            }
            $shopSms = get_data_by_id('sms', 'shops', 'sch_id', $shopId);
            if ($shopSms >= $totalSmsSend) {
                $sendSms = $totalSmsSend;
            }
            $smsPhone = get_data_by_id('phone', 'loan_provider', 'loan_pro_id', $loanProId);
            //sms setting(end)

            if ($chequeNo > 0) {

                //cheque pay amount calculate and insert cheque tabile(start)
                $chequeData = array(
                    'sch_id' => $shopId,
                    'chaque_number' => $chequeNo,
                    'to' => $userId,
                    'from_loan_provider' => $loanProId,
                    'amount' => $chequeAmount,
                    'createdDtm' => date('Y-m-d h:i:s'),

                );

                $this->chaqueModel->insert($chequeData);

                //smsSend
                sms_send($smsMessage, $smsPhone);

                $this->session->setFlashdata('message', '<div style="margin-top: 12px" class="alert alert-success" id="message">Create Record Success <br><small>sms send: ' . $sendSms . ' </small></div>');
                return redirect()->to('shop_admin/bakir_hishab/create');

                //cheque pay amount calculate and insert cheque tabile(end)

            } else {
                //Cr.
                if ($trangactionType == 2) {
                     $this->db->transStart();
                    //insert Transaction table
                    // $this->request->getFile('image');
                     $photo_name = 'tran_lone_' . time() . '.jpg';
                    // $config['upload_path'] = './../uploads/tran_lone_image/';
                    // $config['allowed_types'] = 'gif|jpg|png';
                    // $config['file_name'] = $photo_name;
                    // $this->load->library('upload', $config);


                    // if ($this->upload->do_upload('image')) {
                    //     $image = $photo_name;

                    // } else {
                    //     $image = null;
                    // }
                    $image = $this->request->getFile('image');
                    
                    $validationRule = [
                        'userfile' => [
                            'label' => 'image',
                            'rules' => [
                                'is_image[image]',
                            ],
                        ],
                    ];

                    if (! $this->validate($validationRule)) {
                      
                        $image = null;
                    }else{
 
                        if (!$image->hasMoved()) {
                            $filepath = WRITEPATH  . $image->store('uploads/tran_lone_image/',$photo_name);
    
                            $data = ['uploaded_fileinfo' => new File($filepath)];
    
                       
                            $image = $photo_name;
                        
                        }
                    }
                   
                   

                    $transdata = array(
                        'sch_id' => $shopId,
                        'loan_pro_id' => $loanProId,
                        'title' => $this->request->getPost('particulars'),
                        'trangaction_type' => 'Dr.',
                        'amount' => $amount,
                        'image' => $image,
                        'createdBy' => $userId,
                        'createdDtm' => date('Y-m-d h:i:s'),
                    );
                   
                    $this->transactionModel->insert($transdata);
                    $transId = $this->transactionModel->getInsertID();
                    
                   
                   
                    
                    //insert data
                    $data = array(
                        'sch_id' => $shopId,
                        'trans_id' => $transId,
                        'loan_pro_id' => $loanProId,
                        'particulars' => $this->request->getPost('particulars'),
                        'trangaction_type' => 'Dr.',
                        'amount' => $amount,
                        'rest_balance' => $restBalanceDr,
                        'createdBy' => $userId,
                        'createdDtm' => date('Y-m-d h:i:s'),

                    );
                    $this->ledgerloanModel->insert($data);
                    //loan_provider Balance Update
                    $dataLonProBlan = array(
                        'balance' => $restBalanceDr,
                        'updatedBy' => $userId,

                    );
                     $this->loanproviderModel->where('loan_pro_id',$loanProId)->update($loanProId,$dataLonProBlan);
                    
                    //admin transaction
                    if ($paymentType == 2) {
                        //shop balance update
                        $shopData = array(
                            'cash' => $shopUpdateBalanceCr,
                            'updatedBy' => $userId,

                        );

                        //insert ledger_nagodan
                        $lgNagData = array(
                            'sch_id' => $shopId,
                            'trans_id' => $transId,
                            'loan_pro_id' => $loanProId,
                            'particulars' => $this->request->getPost('particulars'),
                            'trangaction_type' => 'Dr.',
                            'amount' => $amount,
                            'rest_balance' => $restBalanceDr,
                            'createdBy' => $userId,
                            'createdDtm' => date('Y-m-d h:i:s'),

                        );
                        $this->ledgerloanModel->insert($lgNagData);

                    } else {
                        $bankData = array(
                            'balance' => $bankUpDataCr,
                            'updatedBy' => $userId,

                        );
                        $this->bankModel->where('bank_id',$bankId)->update($bankId,$bankData);
                      
                        // $this->db->update('bank', $bankData);
                        //insert ledger_bank
                        $lgBankData = array(
                            'sch_id' => $shopId,
                            'bank_id' => $bankId,
                            'trans_id' => $transId,
                            'trangaction_type' => 'Dr.',
                            'particulars' => $this->request->getPost('particulars'),
                            'amount' => $amount,
                            'rest_balance' => $bankUpDataCr,
                            'createdBy' => $userId,
                            'createdDtm' => date('Y-m-d h:i:s'),

                        );
                        $this->ledgerbankModel->insert($lgBankData);
    
                    }
                     $this->db->transComplete();
                    
                    //smsSend
                    sms_send($smsMessage, $smsPhone);

                    $this->session->setFlashdata('message', '<div style="margin-top: 12px" class="alert alert-success" id="message">Create Record Success <br><small>sms send: ' . $sendSms . ' </small></div>');
                    // redirect(site_url('bakir_hishab/create'));
                    return redirect()->to('shop_admin/bakir_hishab/create');
                }
            }
            //Dr.
            if ($trangactionType == 1) {
                if ($availableBalance == true) {
                    $this->db->transStart();
                    //insert Transaction table

                     $photo_name = 'tran_lone_' . time() . '.jpg';
                  

                    $image = $this->request->getFile('image');
                    
                    $validationRule = [
                        'userfile' => [
                            'label' => 'image',
                            'rules' => [
                                'is_image[image]',
                            ],
                        ],
                    ];

                    if (! $this->validate($validationRule)) {
                       
                        $image = null;
                    }else{
 
                        if (!$image->hasMoved()) {
                            $filepath = WRITEPATH  . $image->store('uploads/tran_lone_image/',$photo_name);
    
                            $data = ['uploaded_fileinfo' => new File($filepath)];
    
                          
                            $image = $photo_name;
                              
                        }
                    }
                   
                   
                    $transdata = array(
                        'sch_id' => $shopId,
                        'loan_pro_id' => $loanProId,
                        'title' => $this->request->getPost('particulars'),
                        'trangaction_type' => 'Cr.',
                        'amount' => $amount,
                        'image' => $image,
                        'createdBy' => $userId,
                        'createdDtm' => date('Y-m-d h:i:s'),

                    );
                    $this->transactionModel->insert($transdata);
                    $transId =$this->transactionModel->getInsertID();
                    $tel = $this->transactionModel->where('trans_id', $transId)->first();
              
                    //insert data
                    $data = array(
                        'sch_id' => $shopId,
                        'trans_id' => $transId,
                        'loan_pro_id' => $loanProId,
                        'particulars' => $this->request->getPost('particulars'),
                        'trangaction_type' => 'Cr.',
                        'amount' => $amount,
                        'rest_balance' => $restBalance,
                        'createdBy' => $userId,
                        'createdDtm' => date('Y-m-d h:i:s'),

                    );
                    $this->ledgerloanModel->insert($data);
                    //loan_provider Balance Update
                    $dataLonProBlan = array(
                        'balance' => $restBalance,
                        'updatedBy' => $userId,

                    );
                    $this->loanproviderModel->where('loan_pro_id', $loanProId)->update($loanProId, $dataLonProBlan);
                    //admin transaction
                    if ($paymentType == 2) {
                        //shop balance update
                        $shopData = array(
                            'cash' => $shopUpdateBalance,
                            'updatedBy' => $userId,

                        );
                        $this->shopsModel->where('sch_id', $shopId)->update($shopId, $shopData);

                        //insert ledger_nagodan
                        $lgNagData = array(
                            'sch_id' => $shopId,
                            'trans_id' => $transId,
                            'particulars' => $this->request->getPost('particulars'),
                            'trangaction_type' => 'Cr.',
                            'amount' => $amount,
                            'rest_balance' => $shopUpdateBalance,
                            'createdBy' => $userId,
                            'createdDtm' => date('Y-m-d h:i:s'),

                        );
                        $this->ledgernagodanModel->insert( $lgNagData);

                    } else {
                        $bankData = array(
                            'balance' => $bankUpData,
                            'updatedBy' => $userId,

                        );
                        $this->bankModel->where('bank_id', $bankId)->update($bankId, $bankData);
                        //insert ledger_bank
                        $lgBankData = array(
                            'sch_id' => $shopId,
                            'bank_id' => $bankId,
                            'trans_id' => $transId,
                            'trangaction_type' => 'Cr.',
                            'particulars' => $this->request->getPost('particulars'),
                            'amount' => $amount,
                            'rest_balance' => $bankUpData,
                            'createdBy' => $userId,
                            'createdDtm' => date('Y-m-d h:i:s'),

                        );
                        $this->ledgerbankModel->insert( $lgBankData);

                    }
                    $this->db->transComplete();
                  

                    //sms send(start)
                    sms_send($smsMessage, $smsPhone);
                    //sms send(end)
                
                    $this->session->setFlashdata('message', '<div style="margin-top: 12px" class="alert alert-success" id="message">Create Record Success <br><small>sms send: ' . $sendSms . ' </small></div>');
                    // redirect(site_url('shop_admin/bakir_hishab/create'));
                    return redirect()->to('shop_admin/bakir_hishab/create');

                } else {
                   
                    $this->session->setFlashdata('message', '<div style="margin-top: 12px" class="alert alert-danger" id="message">Not Enough Balance</div>');
                    return redirect()->to('shop_admin/bakir_hishab/create');
                }
            }
        }
    }

    public function lonProvData()
    {
        $lonProvId = $this->request->getPost('lonProvId');

        
        $data= $this->ledgerloanModel->where('loan_pro_id', $lonProvId)->orderBy('ledg_loan_id', "DESC")->findAll(10);
       
        
        $loanProBalance = get_data_by_id('balance', 'loan_provider', 'loan_pro_id', $lonProvId);

        $view = '<span class="pull-right"> Balance: ' . showWithCurrencySymbol($loanProBalance) . '</span>';
        $view .= '<table class="table table-bordered table-striped text-capitalize" id="TFtable">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Particulars</th>
                                    <th>Debit</th>
                                    <th>Credit</th>
                                    <th>Balance</th>
                                </tr>
                            </thead>
                            <tbody>';
        $i = '';
        foreach ($data as $row) {
            $particulars = ($row->particulars == NULL) ? "Loan" : '<a href="' . site_url('transaction/read/' . $row->trans_id) . '">' . $row->particulars . '</a>';
            $loanProId = get_data_by_id('name', 'loan_provider', "loan_pro_id", $row->loan_pro_id);
            $amountCr = ($row->trangaction_type != "Cr.") ? "---" : showWithCurrencySymbol($row->amount);
            $amountDr = ($row->trangaction_type != "Dr.") ? "---" : showWithCurrencySymbol($row->amount);
            $view .= '<tr>
                                    <td>' . bdDateFormat($row->createdDtm) . '</td>
                                    <td>' . $particulars . '</td>
                                    <td>' . $amountDr . '</td>
                                    <td>' . $amountCr . '</td>
                                    <td>' . showWithCurrencySymbol($row->rest_balance) . '</td>
                                </tr>';
        }

        $view .= '</tbody>
                            <tfoot>
                                <tr>
                                    <th>Date</th>
                                    <th>Particulars</th>
                                    <th>Debit</th>
                                    <th>Credit</th>
                                    <th>Balance</th>
                                </tr>
                            </tfoot>
                        </table>';


        print $view;
    }

}