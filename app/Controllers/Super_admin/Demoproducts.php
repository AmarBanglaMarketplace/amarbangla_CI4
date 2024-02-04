<?php

namespace App\Controllers\Super_admin;

use App\Controllers\BaseController;
use App\Libraries\Mycart;
use App\Libraries\Permission;
use App\Models\DemocategoryModel;
use App\Models\DemoproductsModel;


class Demoproducts extends BaseController
{
    protected $validation;
    protected $session;
    protected $demoproductsModel;
    protected $democategoryModel;
    protected $cart;

    protected $crop;
    protected $permission;

    public function __construct()
    {
        $this->demoproductsModel = new DemoproductsModel();
        $this->democategoryModel = new DemocategoryModel();
        $this->validation = \Config\Services::validation();
        $this->session = \Config\Services::session();
        $this->cart = new Mycart();
        $this->permission = new Permission();
        $this->crop = \Config\Services::image();
    }
    public function index() {
        $isLoggedInSuperAdmin = $this->session->isLoggedInSuperAdmin;
        if (!isset($isLoggedInSuperAdmin) || $isLoggedInSuperAdmin != TRUE) {
            return redirect()->to(site_url("super_admin"));
        } else {

            $data['product'] = $this->demoproductsModel->findAll();

            echo view('Super_admin/header');
            echo view('Super_admin/sidebar');
            echo view('Super_admin/Demoproducts/index',$data);
            echo view('Super_admin/footer');
        }
    }

    public function create_action(){
        $name = $this->request->getPost('name[]');
        $unit = $this->request->getPost('unit[]');
        $prod_cat_id = $this->request->getPost('prod_cat_id[]');

        if (!empty($name)) {
            foreach ($name as $key => $val){
                $data['name'] = $val;
                $data['unit'] = $unit[$key];
                $data['prod_cat_id'] = $prod_cat_id[$key];
                $this->demoproductsModel->insert($data);
            }

            $this->cart->destroy();
            $this->session->setFlashdata('message', '<div class="alert alert-success alert-dismissible" role="alert">Data insert successfully <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            return redirect()->to('super_admin/demo_product');
        }else{
            $this->session->setFlashdata('message', '<div class="alert alert-danger alert-dismissible" role="alert">Your cart is empty!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            return redirect()->to('super_admin/demo_product');
        }
    }


    public function product_list(){
        $isLoggedInSuperAdmin = $this->session->isLoggedInSuperAdmin;
        if (!isset($isLoggedInSuperAdmin) || $isLoggedInSuperAdmin != TRUE) {
            return redirect()->to(site_url("super_admin"));
        } else {

            $data['product'] = $this->demoproductsModel->orderBy('id','DESC')->findAll();
            $data['category'] = $this->democategoryModel->where('parent_pro_cat','0')->findAll();

            echo view('Super_admin/header');
            echo view('Super_admin/sidebar');
            echo view('Super_admin/Demoproducts/list',$data);
            echo view('Super_admin/footer');
        }
    }

    public function update($id){
        $isLoggedInSuperAdmin = $this->session->isLoggedInSuperAdmin;
        if (!isset($isLoggedInSuperAdmin) || $isLoggedInSuperAdmin != TRUE) {
            return redirect()->to(site_url("super_admin"));
        } else {

            $data['product'] = $this->demoproductsModel->where('id',$id)->first();

            echo view('Super_admin/header');
            echo view('Super_admin/sidebar');
            echo view('Super_admin/Demoproducts/update',$data);
            echo view('Super_admin/footer');
        }
    }

    public function update_action()
    {
        $supuserId = $this->session->userIdSuper;

        $subCatId = $this->request->getPost('sub_cat_id');
        $catId = $this->request->getPost('prod_cat_id');

        $data['id'] = $this->request->getPost('id');
        $data['name'] = $this->request->getPost('name');
        $data['unit'] = $this->request->getPost('unit');
        $data['size'] = $this->request->getPost('size');
        $data['purchase_price'] = $this->request->getPost('purchase_price');
        $data['selling_price'] = $this->request->getPost('selling_price');
        $data['quantity'] = $this->request->getPost('quantity');
        $data['description'] = $this->request->getPost('description');
        if (!empty($subCatId)) {
            $data['prod_cat_id'] = $subCatId;
        } else {
            $data['prod_cat_id'] = $catId;
        }

        $this->validation->setRules([
            'name' => ['label' => 'name', 'rules' => 'required'],
        ]);

        if ($this->validation->run($data) == FALSE) {
            $this->session->setFlashdata('message', '<div class="alert alert-danger alert-dismissible" role="alert">' . $this->validation->listErrors() . ' <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            return redirect()->to('super_admin/demo_product_update/' . $data['id'].'?active=general');
        } else {

            $this->demoproductsModel->update($data['id'], $data);

            $this->session->setFlashdata('message', '<div class="alert alert-success alert-dismissible" role="alert">Data update successfully <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            return redirect()->to('super_admin/demo_product_update/' . $data['id'].'?active=general');

        }
    }

    public function photo_action(){
        $supuserId = $this->session->userIdSuper;


        $data['id'] = $this->request->getPost('id');

        $this->validation->setRules([
            'id' => ['label' => 'id', 'rules' => 'required'],
        ]);

        if ($this->validation->run($data) == FALSE) {
            $this->session->setFlashdata('message', '<div class="alert alert-danger alert-dismissible" role="alert">' . $this->validation->listErrors() . ' <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            return redirect()->to('super_admin/demo_product_update/' . $data['id'].'?active=photo');
        } else {

            if (!empty($_FILES['userfile']['name'])) {
                $target_dir = FCPATH . '/uploads/demo_product_image/'.$data['id'].'/';
                if (!file_exists($target_dir)) {
                    mkdir($target_dir, 0777);
                }
                $uploadData = array();
                //new image uplode
                $pic = $this->request->getFileMultiple('userfile');
                $lastKey =  array_key_last($pic);
                foreach ($pic as $key => $val){
                    if ($key != $lastKey) {
                        $namePic = $val->getRandomName();
                        $val->move($target_dir, $namePic);
                        $pro_nameimg = 'product_' . $val->getName();
                        $this->crop->withFile($target_dir . '' . $namePic)->fit(210, 210, 'center')->save($target_dir . '210_' . $pro_nameimg,100);
                        $this->crop->withFile($target_dir . '' . $namePic)->fit(150, 150, 'center')->save($target_dir . '150_' . $pro_nameimg,100);
                        $this->crop->withFile($target_dir . '' . $namePic)->fit(90, 90, 'center')->save($target_dir . '90_' . $pro_nameimg,100);
                        $this->crop->withFile($target_dir . '' . $namePic)->fit(98, 98, 'center')->save($target_dir . '98_' . $pro_nameimg,100);
                        $this->crop->withFile($target_dir . '' . $namePic)->fit(70, 70, 'center')->save($target_dir . '70_' . $pro_nameimg,100);

                        $uploadData[$key] = $pro_nameimg;
                    }
                }
                $json = json_encode($uploadData);
                $data['picture'] = $json;
                $this->demoproductsModel->update($data['id'], $data);

                $this->session->setFlashdata('message', '<div class="alert alert-success alert-dismissible" role="alert">Data update successfully <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                return redirect()->to('super_admin/demo_product_update/' . $data['id'].'?active=photo');
            } else {
                $this->session->setFlashdata('message', '<div class="alert alert-danger alert-dismissible" role="alert">Please select any image!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                return redirect()->to('super_admin/demo_product_update/' . $data['id'] . '?active=photo');
            }



        }
    }

    public function delete($id){
        $isLoggedInSuperAdmin = $this->session->isLoggedInSuperAdmin;
        if (!isset($isLoggedInSuperAdmin) || $isLoggedInSuperAdmin != TRUE) {
            return redirect()->to(site_url("super_admin"));
        } else {
            $supuserId = $this->session->userIdSuper;
            $data['id'] = $id;
            $this->demoproductsModel->delete($data['id']);
            $this->session->setFlashdata('message', '<div class="alert alert-success alert-dismissible" role="alert">Delete Record Success <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            return redirect()->to('super_admin/demo_product_list');

        }
    }

    public function get_sub_cat(){
        $cat_id = $this->request->getPost('cat_id');
        $query = $this->democategoryModel->where('parent_pro_cat', $cat_id)->findAll();
        $options = '';
        foreach ($query as $row) {
            $options .= '<option value="' . $row->cat_id . '" ';
            $options .= '>' . $row->product_category . '</option>';
        }
        print $options;
    }

    public function addCart(){
        $subCatId = $this->request->getPost('subCatId');
        $category = $this->request->getPost('category');
        $name = $this->request->getPost('name');
        $unit = $this->request->getPost('unit');
        $qty = $this->request->getPost('qty');

        $i = count($this->cart->contents());

        $data = array(
            'id' => ++$i,
            'name' => strval($name),
            'unit' => $unit,
            'qty' => $qty,
            'price' => '0',
        );

        if (!empty($subCatId)) {
            $data['cat_id'] = $subCatId;
        } else {
            $data['cat_id'] = $category;
        }

        if ($this->cart->insert($data)) {
            print '<div class="alert alert-success alert-dismissible" role="alert">Add to cart Success <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
        }else{
            print '<div class="alert alert-danger alert-dismissible" role="alert">Something went wrong please try again! <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
        }
    }

    public function remove_cart()
    {
        $id = $this->request->getPost('id');

        if ($this->cart->remove($id)) {
            print '<div class="alert alert-success alert-dismissible" role="alert">Remove to cart Success <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
        }else{
            print '<div class="alert alert-danger alert-dismissible" role="alert">Something went wrong please try again! <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
        }
    }

    public function clearCart()
    {
        $this->cart->destroy();
        print '<div class="alert alert-success alert-dismissible" role="alert">Remove to cart Success <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';

    }

    public function search_keyword(){
        $keyword = $this->request->getPost('keyword');
//        $where = "(`name` LIKE '%" . $keyword . "%' ESCAPE '!' OR `id` LIKE '%" . $keyword . "%' ESCAPE '!')";
        $data = $this->demoproductsModel->like('name',$keyword)->orLike('id',$keyword)->findAll();

        $view = '';
        foreach ($data as $val) {
            $image = demo_singleImage_by_productId($val->id,'70','0','');
            $view .= '<tr>
                        <td>' .$val->id . '</td>
                        <td>' . $val->name . '</td>
                        <td>' . $image . '</td>
                        <td>' . get_data_by_id('product_category', 'demo_category', 'cat_id', $val->prod_cat_id) . '</td>
                        <td>' . showWithCurrencySymbol($val->purchase_price) . '</td>
                    	<td>' . showWithCurrencySymbol($val->selling_price) . '</td>
                        
                        <td>
                            <a href="' . site_url('super_admin/demo_product_update/' . $val->id) . '" class="btn btn-xs btn-info " >Edit</a>
                            <a href="' . site_url('super_admin/demo_product_delete/' . $val->id) . '"  class="btn btn-xs btn-danger" >Delete</a>
                        </td>
                    </tr>';
        }

        print $view;
    }

    public function search_category(){
        $keyWord = $this->request->getPost('catId');
        $parentCat = checkParentCategorydemo($keyWord);

        $view = '';
        if ($parentCat == 0) {
            $subCatId = $this->democategoryModel->where('parent_pro_cat', $keyWord)->findAll();
            foreach ($subCatId as $row) {
                $data = $this->demoproductsModel->where('prod_cat_id', $row->cat_id)->findAll();
                foreach ($data as $val) {
                    $image = demo_singleImage_by_productId($val->id,'70','0','');
                    $view .= '<tr>
                        <td>' . $val->id . '</td>
                        <td>' . $val->name . '</td>
                        <td>' . $image . '</td>
                        <td>' . get_data_by_id('product_category', 'demo_category', 'cat_id', $val->prod_cat_id) . '</td>
                        <td>' . showWithCurrencySymbol($val->purchase_price) . '</td>
                    	<td>' . showWithCurrencySymbol($val->selling_price) . '</td>
                        <td>
                            <a href="' . site_url('super_admin/demo_product_update/' . $val->id) . '" class="btn btn-xs btn-info " >Edit</a>
                            <a href="' . site_url('super_admin/demo_product_delete/' . $val->id) . '" class="btn btn-xs btn-danger" >Delete</a>
                        </td>
                    </tr>';
                }

            }
        } else {
            $data2 = $this->demoproductsModel->where('prod_cat_id', $keyWord)->findAll();
            foreach ($data2 as $val) {
                $image = demo_singleImage_by_productId($val->id,'70','0','');
                $view .= '<tr>
                            <td>' . $val->id . '</td>
                            <td>' . $val->name . '</td>
                            <td>' . $image . '</td>
                            <td>' . get_data_by_id('product_category', 'demo_category', 'cat_id', $val->prod_cat_id) . '</td>
                            <td>' . showWithCurrencySymbol($val->purchase_price) . '</td>
                            <td>' . showWithCurrencySymbol($val->selling_price) . '</td>
                            
                            <td>
                                <a href="' . site_url('super_admin/demo_product_update/' . $val->id) . '" class="btn btn-xs btn-info " >Edit</a>
                                <a href="' . site_url('super_admin/demo_product_delete/' . $val->id) . '" class="btn btn-xs btn-danger" >Delete</a>
                            </td>
                        </tr>';
            }
        }


        print $view;
    }



}
