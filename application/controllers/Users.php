<?php
 
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends My_Controller {

    public function __construct() {
        parent::__construct();
    }

    /**
     * This is the org list
     * @AclName List
     */
    public function index() {
        echo $msg = __CLASS__ . ' - ' . __FUNCTION__ . '<br />';
        log_message('debug',$msg);
    }

    /**
     * This is the org list
     * @AclName Add
     */
    public function add() {
        echo $msg = __CLASS__ . ' - ' . __FUNCTION__ . '<br />';
        log_message('debug',$msg);
    }

    /**
     * This is the org list
     * @AclName Edit
     */
    public function edit() {
        echo $msg = __CLASS__ . ' - ' . __FUNCTION__ . '<br />';
        log_message('debug',$msg);
    }
    
    /**
     * This is the org list
     * @AclName Show
     */
    public function show() {
        echo $msg = __CLASS__ . ' - ' . __FUNCTION__ . '<br />';
        log_message('debug',$msg);
    }

}
