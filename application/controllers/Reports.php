<?php

defined('BASEPATH') OR exit('No direct script access allowed');
 
class Reports extends My_Controller {

    public function __construct() {
        parent::__construct();
    }

    /**
     * This is the index function
     * @AclName Listing Page 
     * 
     */
    public function index() {
        echo $msg = __CLASS__ . ' - ' . __FUNCTION__ . '<br />';
        log_message('debug',$msg);
    }

    
    /**
     * This is the org list
     * @AclName Org List
     */
    public function orglist() {
        echo $msg = __CLASS__ . ' - ' . __FUNCTION__ . '<br />';
        log_message('debug',$msg);
    }

    public function alllist() {
        echo $msg = __CLASS__ . ' - ' . __FUNCTION__ . '<br />';
        log_message('debug',$msg);
    }

}
