<?php
 
defined('BASEPATH') OR exit('No direct script access allowed');

class Curl extends My_Controller {

    public function __construct() {
        parent::__construct();
    }
    
    public function index(){
        print_r($_POST);
        echo '<br />';
        print_r($_FILES);
        print_r($_REQUEST);
    }

}
