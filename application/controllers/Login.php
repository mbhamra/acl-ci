<?php

class Login extends MY_Controller{
    
    public function __construct(){
        parent::__construct();
        $this->load->model('UsersModel');
    }
    
    /**
     * Login page
     * 
     * @AclName Login
     */
    public function index(){
        $user = $this->session->userdata('user');
        if(!empty($user)){
            redirect('/users');
        }
        $error = '';
        if($this->input->server('REQUEST_METHOD') == 'POST'){
            if($this->_validateForm()){
                $data = $this->input->post();
                $user = $this->UsersModel->verifyLogin($data['username'], $data['password']);
                if(!empty($user)){
                    $this->session->set_userdata('user',$user);
                    $this->session->set_userdata('logged_in',true);
                    redirect('/users/');
                } else {
                    $error = 'Invalid credentials';
                }
            }
            
        }
        $this->render('login', ['error' => $error]);
    }
    
    /**
     * Logout page
     * 
     * @AclName Logout
     */
    public function logout(){
        $this->session->unset_userdata('user');
        $this->session->unset_userdata('logged_in');
        redirect('/login');
    }
    
    /**
     * validate form
     * 
     * @return boolean
     */
    private function _validateForm(){
        $rules = [
            [
                'field' => 'username',
                'label' => 'Username',
                'rules' => 'required'
            ],
            [
                'field' => 'password',
                'label' => 'Password',
                'rules' => 'required'
            ]
        ];
        $this->form_validation->set_rules($rules);
        return $this->form_validation->run();
    }
}