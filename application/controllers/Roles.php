<?php
 
defined('BASEPATH') OR exit('No direct script access allowed');

class Roles extends My_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('RolesModel');
        $this->load->model('AcosModel');
    }

    /**
     * This is the org list
     * @AclName List
     */
    public function index() {
        $roles = $this->RolesModel->getList();
        $this->render('Roles/list',['roles'=>$roles]);
    }
    
    /**
     * This is the org list
     * @AclName Add
     */
    public function add() {
        $data = [];
        $acos = $this->AcosModel->getList();
        if($this->input->server('REQUEST_METHOD') == 'POST'){
            if($this->_validateForm()){
                log_message('info','form validated');
                
                $data = $this->input->post(); //get formatted data
                $this->_save($data);
                redirect('/roles/');
            } else {
                
                log_message('info','form validation errors');
                $data = $this->input->post(); //get un-formatted data
            }
        }
        $this->render('Roles/add',['data'=>$data, 'acos'=>$acos]);
    }

    /**
     * validate form
     * 
     * @return boolean
     */
    private function _validateForm(){
        //defines the rules for register form
        $rules = [
            [
                'field' => 'name',
                'label' => 'Name',
                'rules' => 'trim|required|max_length[50]|callback_validateName'
            ],
            [
                'field' => 'role_permission[]|numeric',
                'label' => 'Roles',
                'rules' => 'required'
            ]
        ];
        //set the rules for register form
        $this->form_validation->set_rules($rules);
        //return validation value in boolean
        return $this->form_validation->run();
    }
    
    /**
     * Save record
     * 
     * @param type $data
     */
    private function _save($data){
        
        $this->RolesModel->save($data);
    }

    /**
     * This is the org list
     * @AclName Edit
     */
    public function edit($id) {
        
        $acos = $this->AcosModel->getList();
        $data = $this->RolesModel->getById($id);
        if(empty($data)){
            redirect('roles/');
        }
        
        $data['role_permission'] = strpos($data['acos'], ',') === false? [$data['acos']] : explode(', ', $data['acos']);
        
        if($this->input->server('REQUEST_METHOD') == 'POST'){
            if($this->_validateForm()){
                log_message('info','form validated');
                
                $data = $this->input->post(); //get formatted data
                $data['id'] = $id;
                $this->_save($data);
                
                redirect('roles/');
            } else {
                
                log_message('info','form validation errors');
                $data = $this->input->post(); //get un-formatted data
            }
        }
        $this->render('Roles/edit',['data'=>$data, 'acos'=>$acos]);
    }
    
    /**
     * delete role
     * 
     * Note: change this functionality for security purpose, 
     * @param type $id
     * @AclName Delete
     */
    public function delete($id){
        $role = $this->RolesModel->getById($id);
        if(empty($role)){
            redirect('/roles/');
        }
        $this->RolesModel->delete($id);
        redirect('/roles/');
    }
    
    /**
     * validate name
     * 
     * @param type $name
     * @return boolean
     */
    public function validateName($name){
        //get id from the url
        $id = $this->uri->segment('3');
        $exist = $this->RolesModel->isNameExists($name, $id);

        if($exist === false){
            //name does not exists in table
            return true;
        }
        //name exists and throw error
        $this->form_validation->set_message(__FUNCTION__, "{field} $name is already exists.");
        return false;
    }
}
