<?php
 
class Acl extends MY_Controller{
    public function __construct(){
        parent::__construct();
        $this->load->library('acl');
    }
    
    public function index(){
        $this->acl->read();
        $r = new ReflectionClass($class);
        $doc = $r->getDocComment();
        preg_match_all('#@(.*?)\n#s', $doc, $annotations);
        return $annotations[1];
    }
}