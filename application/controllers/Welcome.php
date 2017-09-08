<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends My_Controller {

    public function __construct() {
        parent::__construct();
    }

    /**
     * @AclName Welcome
     */
    public function index() {
        log_message('info', 'message');
        $this->load->view('welcome_message');
    }

    /**
     * This is the org list
     * @AclName Restricted
     */
    public function restricted() {
        echo 'you are authorized to view this page.';
    }
    
    /**
     * unauthorized page
     */
    public function unauthorized(){
        echo 'you are unauthorized to view page';
    }
}
