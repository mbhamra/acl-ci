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
     * unauthorized page
     */
    public function unauthorized(){
        http_response_code(401);
        echo 'you are unauthorized to view page';
    }
}
