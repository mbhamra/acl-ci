<?php
if(!function_exists('br')){
    /**
     * br function to print <br /> in html content 
     * 
     * @param type $i
     * @return string
     */
    function br($i=1){
        $content = '';
        do{
            $content .= '<br />';
            $i--;
        }while($i>0);
        
        return $content;
    }
}

//check hasPermission function exists
if(!function_exists('hasPermission')){
   
    /**
     * check user has permission
     * 
     * @param string $class
     * @param string $method
     * @return boolean
     */
    function hasPermission($class, $method){
        
        $acl = ACL::get_instance();
        return $acl->hasPermission($class, $method);
    }
}