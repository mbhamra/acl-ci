<?php

class RolesModel extends MY_Model {

    protected $table = 'roles';
    protected $alias = 'r';

    public function getList($conditions = [], $count = false, $limit = 0, $offset = 0) {
        $table = $this->table;
        $alias = $this->alias;
        $this->db->from($table . ' as ' . $alias);
        $select = "$alias.id, $alias.name, (select GROUP_CONCAT(acl.aco_id SEPARATOR ',') from acl where acl.role_id = $alias.id) as acos";
        
        if (!empty($conditions)) {
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
        $conditions = [
            'id' => $id,
        ];
        $roles = $this->getList($conditions);
        if(!empty($roles)){
            $roles = $roles[0];
        }
        return $roles;
    }
    
    /**
     * get guest group
     * 
     * @return array
     */
    public function getGuestGroup(){
        $conditions = [
            'name' => 'Guest'
        ];
        $group = $this->getList($conditions);
        if(!empty($group)){
            $group = $group[0];
            $this->load->model('AcosModel');
            $ids = strpos($group['acos'], ',') === false? $group['acos'] : explode(', ', $group['acos']);
            $group['acos'] = $this->AcosModel->getByMultiId($ids);
            
            return $group;
        }
        return [];
    }
    
    /**
     * check name exists 
     * 
     * @param type $name
     * @param type $id
     * @return boolean
     */
    public function isNameExists($name, $id = null){
        $conditions = [
            $this->alias.'.name' => $name
        ];
        if(!empty($id) && is_numeric($id)){
            $conditions[$this->alias.'.id !='] = $id;
        }
        $count = $this->getList($conditions, true);
        if($count > 0)
            return true;
        
        return false;
    }
    
    /**
     * save role
     * 
     * @param type $data
     * @return boolean
     */
    public function save($data) {
        $this->db->trans_start();
        $save = [
            'name' => $data['name']
        ];
        if (isset($data['id']) && !empty($data['id'])) {
            $id = $data['id'];
            $result = $this->update($save, $id);
            if($result === true){
                $this->saveRolePermission($id, $data['role_permission']);
            } else {
                $this->db->trans_rollback();
            }
        } else {
            $result = $this->insert($save);
            if($result === true){
                $this->saveRolePermission($this->db->insert_id(), $data['role_permission']);
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
     * save role permission
     * 
     * @param type $role_id
     * @param type $acos
     * @return boolean
     */
    public function saveRolePermission($role_id, $acos){
        log_message('info','Saving role permission to role-'.$role_id);
        
        $this->load->model('AclModel');
        $result = $this->AclModel->saveBatch(['role_id'=>$role_id, 'acos' => $acos]);
        
        log_message('info','Saved role permission to role-'.$role_id);
        return $result;
    }
    
    /**
     * delete role
     * 
     * @param type $id
     * @return boolean
     */
    public function delete($id){
        //load user roles model
        $this->load->model('UserRolesModel');
        //delete record associated with role id in user roles table
        $this->UserRolesModel->deleteByRole($id);
        //load acl model
        $this->load->model('AclModel');
        //delete records associated with role in acl table
        $this->AclModel->deleteByRole($id);
        $this->db->where(['id'=>$id]);
        $this->db->delete($this->table);
    }
    
    
}
