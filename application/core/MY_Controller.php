<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class MY_Controller extends CI_Controller{
    
    private $layout = 'home';
    
    public function __construct(){
        parent::__construct();
        //$this->output->enable_profiler(true);
        
    }
    
    /**
     * render the view with layout
     * 
     * @param type $page
     * @param type $data
     */
    protected function render($page, $data=[]){
        $acl = ACL::get_instance();
        $data['loggedUser'] = $acl->getLoggedInUser();
        log_message('info','Loading view : ' . $page . ' with layout:' . $this->getLayout());
        $this->load->view($this->getLayout(),['template'=>$page,'data'=>$data]);
    }
    
    /**
     * set layout
     * 
     * @param type $layout
     * @return \MY_Controller
     */
    protected function setLayout($layout){
        $this->layout = $layout;
        return $this;
    }
    
    /**
     * get layout
     * 
     * @return layout
     */
    protected function getLayout(){
        return 'layouts/'.$this->layout;
    }
}