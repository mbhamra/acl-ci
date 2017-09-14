<?php
/**
 * This class will be called by the post_controller_constructor hook and act as ACL
 * 
 * @author Manmohan
 */
class ACL {

    private $CI;
    private $user;
    private static $instance;
    
    /**
     * Constructor
     */
    public function __construct() {
        $this->CI =& get_instance();
        self::$instance = $this;
    }
    
    /**
     * get instance of this class
     * 
     * @return \ACL
     */
    public static function get_instance(){
        return self::$instance;
    }
    
    /**
     * check authorisation the user to access the page
     */
    public function auth(){
        
        $CI = $this->CI;
        
        
        // check guess acces
        if($this->_checkGuestAccess()){
            return true;
        }
        
        //get logged in user details with acl
        $user = $this->getLoggedInUser();
        
        //validate user has permission to view this page
        if(!$this->_validateActionPermission($user['acl'])){
            //check user logged in or not
            if(empty($user)){
                //user not found
                redirect('login');
            } else {
                //user logged in but not have permission to view this page
                exit('unauthorized');
                //redirect('unauthorized');
            }
            
        }
        
        if(!empty($user)){
            //user authorize to view this page
        } else {
            
            redirect('/login');
        }
        
    }
    
    /**
     * get logged in user
     * 
     * @return array
     */
    public function getLoggedInUser(){
        $CI = $this->CI;
        $user = $CI->session->userdata('user');
        
        if(!empty($this->user)){
            return $this->user;
        }
        if (is_numeric($user)){
            //load users model
            $CI->load->model('UsersModel');
            //get detail with acl by id
            $user = $CI->UsersModel->getDetailWithAclById($user);   
        }
        $this->user = $user;
        return $user;
    }
    
    /**
     * check guest accessibility
     * 
     * @param string $class
     * @param string $method
     * @return boolean
     */
    private function _checkGuestAccess($class = null, $method = null){
        $group = $this->CI->session->userdata('groups.guest');
        if(empty($group)){
            $this->CI->load->model('RolesModel');
            $group = $this->CI->RolesModel->getGuestGroup();
            $this->CI->session->set_userdata('groups.guest',$group);
        }
        
        return $this->_validateActionPermission($group['acos'], $class, $method);
    }
    
    /**
     * validate action permissions
     * 
     * @param array $acos
     * @param string $class
     * @param string method
     * @return boolean
     */
    private function _validateActionPermission($acos, $class=null, $method=null){
        //check acos is not empty
        if(empty($acos)){
            return false;
        }
        if(empty($class)){
            $class = $this->CI->router->fetch_class();
        }
        if(empty($method)){
            $method = $this->CI->router->fetch_method();
        }
        
        foreach($acos AS $aco){
            //check user has access permission for class and method
            if(strtolower($aco['class']) == strtolower($class) && strtolower($aco['method']) == strtolower($method)){
                //user has permission to access this page
                return true;
            }
        }
        //user has not permission to access this page
        return false;
    }
    
    /**
     * check has permission
     * 
     * @param string $class
     * @param string $method
     * @return boolean
     */
    public function hasPermission($class, $method){
        //check guest access
        if($this->_checkGuestAccess($class, $method)){
            return true;
        }
        
        $user = $this->user;
        //check user empty or not
        if(!empty($user) && isset($user['acl'])){
            //validate link and return boolean
            return $this->_validateActionPermission($user['acl'], $class, $method);
        }
        return false;
    }
}