<?php
 
class Acl extends MY_Controller{
    public function __construct(){
        parent::__construct();
        //$this->load->library('acl');
    }
    
    public function index(){
        exit(__FUNCTION__);
        $this->acl->read();
        $r = new ReflectionClass($class);
        $doc = $r->getDocComment();
        preg_match_all('#@(.*?)\n#s', $doc, $annotations);
        return $annotations[1];
    }
    
    public function fetch(){
        $this->listFolderFiles();
        
    }
    
    public function listFolderFiles($dir=null){
        if($dir === null)
            $dir = constant('APPPATH').'controllers/';
        $ffs = scandir($dir);

        unset($ffs[0],$ffs[1]);
        // prevent empty ordered elements
        if (count($ffs) < 1)
            return;

        echo '<ol>';
        foreach($ffs as $ff){
            
            
            if(is_dir($dir.'/'.$ff)) 
                    $this->listFolderFiles($dir.'/'.$ff); 
            elseif(is_file($dir.'/'.$ff))
                $this->get_php_classes(file_get_contents($dir.'/'.$ff));die;
            
        }
        echo '</ol>';
    }
    
    public function get_php_classes($php_code) {
        $classes = array();
        $tokens = token_get_all($php_code);
        print_r($tokens);
        $count = count($tokens);
        for ($i = 2; $i < $count; $i++) {
          if (   $tokens[$i - 2][0] == T_CLASS
              && $tokens[$i - 1][0] == T_WHITESPACE
              && $tokens[$i][0] == T_STRING) {

              $class_name = $tokens[$i][1];
              $classes[] = $class_name;
          }
        }
        return $classes;
      }
}