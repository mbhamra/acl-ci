<?php
 
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends My_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('UsersModel');
        $this->load->model('RolesModel');
    }

    /**
     * This is the org list
     * @AclName List
     */
    public function index() {
        $users = $this->UsersModel->getList();
        $this->render('Users/list',['users'=>$users]);
    }

    /**
     * This is the org list
     * @AclName Register
     */
    public function register() {
        $data = [];
        if($this->input->server('REQUEST_METHOD') == 'POST'){
            if($this->_validateForm('register')){
                log_message('info','form validated');
                
                $data = $this->input->post(); //get formatted data
                $this->_save($data);
                redirect('users');
            } else {
                log_message('info','form validation errors');
                $data = $this->input->post(); //get un-formatted data
            }
        }
        $this->render('Users/register',['data'=>$data]);
    }
    
    /**
     * validate form
     * 
     * @param type $action
     * @return boolean
     */
    private function _validateForm($action){
        //defines the rules for register form
        $rules = [
            [
                'field' => 'name',
                'label' => 'Name',
                'rules' => 'trim|required|max_length[60]'
            ]
        ];
        if($action == 'register'){
            $rules[] = [
                'field' => 'username',
                'label' => 'Username',
                'rules' => 'trim|required|max_length[50]|alpha_numeric|callback_validateUsername' //add some more validation according to your requirement to check username
            ];
            
            $rules[] = [
                'field' => 'password',
                'label' => 'Password',
                'rules' => 'required|max_length[60]|alpha_numeric', //add some more validation according to your requirement to check password field
            ];
            $rules[] = [
                'field' => 'cnpassword',
                'label' => 'Confirm Password',
                'rules' => 'required|matches[password]'
            ];
        }
            
        //set the rules for register form
        $this->form_validation->set_rules($rules);
        //return validation value in boolean
        return $this->form_validation->run();
    }
    
    /**
     * save record
     * 
     * @param type $data
     */
    private function _save($data){
        $this->UsersModel->save($data);
    }

    /**
     * This is the org list
     * @AclName Edit
     * @params $id
     */
    public function edit($id) {
        $data = [];
        $roles = $this->RolesModel->getList();
        $tmp = [];
        foreach($roles as $role){
            $tmp[$role['id']] = $role['name'];
        }
        $roles = $tmp;
        unset($tmp);
        $data = $this->UsersModel->getById($id);
        if(empty($data)){
            redirect('users/');
        }
        $data['user_roles'] = strpos($data['roles'], ',') === false?$data['roles'] : explode(', ', $data['roles']);
        if($this->input->server('REQUEST_METHOD') == 'POST'){
            if($this->_validateForm('edit')){
                log_message('info','form validated');
                
                $data = $this->input->post(); //get formatted data
                $data['id'] = $id;
                $this->_save($data);
                redirect('users/');
            } else {
                log_message('info','form validation errors');
                $data = $this->input->post(); //get un-formatted data
            }
        }
        $this->render('Users/edit',['data'=>$data, 'roles' => $roles]);
    }
    
    /**
     * validate username
     * 
     * @param type $username
     * @return boolean
     */
    public function validateUsername($username){
        $id = $this->uri->segment(3);
        $exist = $this->UsersModel->isUsernameExists($username,$id);
        
        if($exist === false){
            //username does not exists in table
            return true;
        }
        //username exists and throw error
        $this->form_validation->set_message(__FUNCTION__, "{field} $username is already exists.");
        return false;
    }
}
