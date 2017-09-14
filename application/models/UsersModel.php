<?php

class UsersModel extends MY_Model {

    protected $table = 'users';
    protected $alias = 'u';
    protected $insert_id;
    /**
     * get list of records
     * 
     * @param type $conditions
     * @param type $count
     * @param type $limit
     * @param type $offset
     * @return array
     */
    public function getList($conditions = [], $count = false, $limit = 0, $offset = 0) {
        $table = $this->table;
        $alias = $this->alias;
        $this->db->from($this->table . ' as ' . $alias);
        $select = "$alias.id, $alias.username, $alias.password, $alias.name, (select GROUP_CONCAT(ur.role_id SEPARATOR ',') from user_roles ur where ur.user_id = $alias.id ) as roles, (select GROUP_CONCAT(r.name SEPARATOR ',') from user_roles ur inner join roles r ON r.id=ur.role_id where ur.user_id = $alias.id ) as roles_name";
       
        if(!empty($conditions)){
            $this->db->where($conditions);
        }
        if (!empty($limit)) {
            $this->db->limit($limit, $offset);
        }

        if ($count === true) {
            return $this->db->get()->num_rows();
        } else {
            $this->db->select($select);
            return $this->db->get()->result_array();
        }
    }

    /**
     * get by id
     * 
     * @param type $id
     * @return array
     */
    public function getById($id){
        $conditions = ['id' => $id];
        $user = $this->getList($conditions);
        if(!empty($user)){
            $user = $user[0];
            return $user;
        }
        return [];
    }
    
    /**
     * save record
     * 
     * @param type $data
     * @return boolean
     */
    public function save($data) {
        $this->db->trans_start();
        
        //encypt the password 
        if(isset($data['password']) && !empty($data['password'])){
            $data['password'] = $this->_hashPassword($data['password']);
        }
        
        if (isset($data['id']) && !empty($data['id'])) {
            $id = $data['id'];
            unset($data['id']);
            $save = $this->_preFormat($data); //format the fields
            
            $result = $this->update($save, $id);
            if($result === true ){
                
                if(isset($data['user_roles'])){
                    $this->saveUserRoles($id, $data['user_roles']);
                }
            } else {
                $this->db->trans_rollback();
            }
        } else {
            $save = $this->_preFormat($data); //format the fields
            
            $result = $this->insert($save);
            if($result === true){
                $id = $this->insert_id;
            } else {
                $this->db->trans_rollback();
            }
        }
        
        if ($this->db->trans_status() === false) {
            
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }
    
    /**
     * hash password
     * 
     * @param type $password
     * @return hash password
     */
    private function _hashPassword($password){
        return hash('sha256', $password);
    }
    
    /**
     * save user roles associated with user
     * 
     * @param type $user_id
     * @param type $role_ids
     * @return boolean
     */
    public function saveUserRoles($user_id, $roles){
        
        log_message('info','Saving role assigned to user-'.$user_id);
        $this->load->model('UserRolesModel');
        
        $result = $this->UserRolesModel->saveBatch(['user_id'=>$user_id, 'roles' => $roles]);
        log_message('info','Saved role assigned to user-'.$user_id);
        return $result;
    }
    
    /**
     * verify login
     * 
     * @param type $username
     * @param type $password
     * @return array
     */
    public function verifyLogin($username, $password){
        $user = $this->getList(['username'=>$username]);
        
        if(!empty($user)){
            
            if($user[0]['password'] === $this->_hashPassword($password)){
                //valid user
                $user = $user[0];
                
                return $user;
            }
        }
        //login credentials wrong
        return [];
    }
    
    /**
     * get user detail with acl by id
     * 
     * @param int $id
     * @return array $user
     */
    public function getDetailWithAclById($id){
        $user = $this->getList(['id'=>$id]);
        if(!empty($user)){
            $user = $user[0];
            $roles = strpos($user['roles'], ',') === false? $user['roles'] : explode(', ', $user['roles']);
            
            $this->load->model('AclModel');
            //get roles by multiple roles for get high performance without use the join tables
            $user['acl'] = $this->AclModel->getByRoles($roles);
        }
        return $user;
    }
    
    /**
     * check permission
     * 
     * @param type $id
     * @param type $permission_id
     * @return boolean
     */
    public function checkPermission($id, $permission_id){
        $table = $this->table;
        $alias = $this->alias;
        $this->db->from("$table as $alias")
                ->join("UserRole ur", "ur.UserID = $alias.ID","inner")
                ->join("Roles r", "r.ID = ur.RoleID", "inner")
                ->join("RolePermission rp", "rp.RoleID = r.ID")
                ->where("rp.PermissionID",$permissionId)
                ->where("r.isDeleted = '0'")
                ->where("$alias.ID",$id);
        if($this->db->get()->num_rows() > 0){
            return true;
        }
        return false;
    }
    
    public function getActiveUserActionPermissions($id){
        $alias = $this->alias;
        $table = $this->table;
        $actionPermissions = [];
        
        $this->db->select("ap.ControllerName, ap.ActionName")
                ->from("$table as $alias")
                ->join("UserRole ur", "ur.UserID = $alias.ID",'inner')
                ->join("Roles r", "r.ID = ur.RoleID", 'inner')
                ->join('RolePermission rp', "rp.RoleID = r.ID", 'inner')
                ->join('Permission p', "p.ID = rp.PermissionID")
                ->join('ActionPermission ap', "ap.PermissionID = p.ID")
                ->where("$alias.ID",$id)
                ->group_by(['ap.ControllerName','ap.ActionName']);
        $actionPermissions = $this->db->get()->result_array();
        
        
        return $actionPermissions;
    }
    
    /**
     * format the array according the user table columns
     * 
     * @param type $data
     * @return array
     */
    private function _preFormat($data){
        $fields = ['username','name','password'];
        
        $save = [];
        foreach($fields AS $val){
            if(isset($data[$val])){
                $save[$val] = $data[$val];
            }
        }
        return $save;
    }
    
    /**
     * is username exists
     * 
     * @param type $username
     * @return boolean
     */
    public function isUsernameExists($username, $id = null){
        $conditions = [
            'username' => $username
        ];
        
        if(!empty($id)){
            $conditions['id !='] = $id;
        }
        $count = $this->getList($conditions, true); //count the records by username
        
        if($count == 0){
            //username exists in table
            return false;
        }
        // username exists in table
        return true;
    }
}
