<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends My_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        echo $msg = __CLASS__ . ' - ' . __FUNCTION__ . '<br />';
        log_message('debug',$msg);
    }

    public function add() {
        echo $msg = __CLASS__ . ' - ' . __FUNCTION__ . '<br />';
        log_message('debug',$msg);
    }

    public function edit() {
        echo $msg = __CLASS__ . ' - ' . __FUNCTION__ . '<br />';
        log_message('debug',$msg);
    }

    public function show() {
        echo $msg = __CLASS__ . ' - ' . __FUNCTION__ . '<br />';
        log_message('debug',$msg);
    }

}
