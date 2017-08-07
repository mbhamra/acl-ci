<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class MY_Controller extends CI_Controller{
    public function __construct(){
        parent::__construct();
        $this->output->enable_profiler(true);
    }
    
    public function loadFrontView($file, $data){
        $this->load->view('layout/header', $data);
        $this->load->view($file, $data);
        $this->load->view('layout/footer', $data);
        
    }
}