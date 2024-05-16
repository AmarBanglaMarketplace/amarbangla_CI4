<?php

namespace App\Controllers\Super_admin;

use App\Controllers\BaseController;
use App\Libraries\Permission;
use App\Models\AgentModel;
use App\Models\CallingrequestModel;
use App\Models\GlobaladdressModel;

class Callingrequest extends BaseController
{
    protected $validation;
    protected $session;
    protected $callingrequestModel;
    protected $agentModel;
    protected $globaladdressModel;

    protected $crop;
    protected $permission;

    public function __construct()
    {
        $this->callingrequestModel = new CallingrequestModel();
        $this->agentModel = new AgentModel();
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

            $data['calling'] = $this->callingrequestModel->findAll();
            $data['agent'] = $this->agentModel->findAll();

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

    public function search_agent(){
        $agent_id = $this->request->getPost('agent_id');
        $status = $this->request->getPost('status');
        if ((!empty($agent_id)) || (!empty($status))){
            $agentWhere = empty($agent_id) ? '1=1' : array('agent_id' => $agent_id);
            $statusWhere = empty($status) ? '1=1' : array('status' => $status);

            $data['calling'] = $this->callingrequestModel->where($agentWhere)->where($statusWhere)->findAll();
            $data['agent'] = $this->agentModel->findAll();

            $data['agent_id'] = $agent_id;
            $data['status'] = $status;

            echo view('Super_admin/header');
            echo view('Super_admin/sidebar');
            echo view('Super_admin/Callingrequest/agent_result',$data);
            echo view('Super_admin/footer');
        }else{
            $this->session->setFlashdata('message', '<div class="alert alert-danger alert-dismissible" role="alert">Sorry! Something is wrong. <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            return redirect()->to('super_admin/calling_request');
        }
    }
    public function search_address(){
        $division = $this->request->getPost('division');
        if (!empty($division)){
            $division = empty($this->request->getPost('division')) ? '1=1' : array('division' => $this->request->getPost('division'));
            $district = empty($this->request->getPost('district')) ? '1=1' : array('zila' => $this->request->getPost('district'));
            $upazila = empty($this->request->getPost('upazila')) ? '1=1' : array('upazila' => $this->request->getPost('upazila'));
            $pourashava = empty($this->request->getPost('pourashava')) ? '1=1' : array('pourashava' => $this->request->getPost('pourashava'));
            $ward = empty($this->request->getPost('ward')) ? '1=1' : array('ward' => $this->request->getPost('ward'));

            $query = $this->globaladdressModel->where($division)->where($district)->where($upazila)->where($pourashava)->where($ward)->findAll();
            $calling = array();
            if (!empty($query)) {
                foreach ($query as $k => $v) {
                    $calling[$k] = $this->callingrequestModel->join('customers','customers.customer_id = calling_request.customer_id')->where('customers.global_address_id',$v->global_address_id)->findAll();
                }
            }

            $data['calling'] = $calling;
            $data['division'] = $this->request->getPost('division');
            $data['district'] = $this->request->getPost('district');
            $data['upazila'] = $this->request->getPost('upazila');
            $data['pourashava'] = $this->request->getPost('pourashava');
            $data['ward'] = $this->request->getPost('ward');

            echo view('Super_admin/header');
            echo view('Super_admin/sidebar');
            echo view('Super_admin/Callingrequest/address_result',$data);
            echo view('Super_admin/footer');

        }else{
            $this->session->setFlashdata('message', '<div class="alert alert-danger alert-dismissible" role="alert">Sorry! Something is wrong. <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            return redirect()->to('super_admin/calling_request');
        }
    }







}
