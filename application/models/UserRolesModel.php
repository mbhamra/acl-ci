<?php

class UserRolesModel extends MY_Model {

    protected $table = 'user_roles';
    protected $alias = 'ur';

    public function getList($conditions = [], $count = false, $limit = 0, $offset = 0) {
        $table = $this->table;
        $alias = $this->alias;
        $this->db->from($table . ' as ' . $alias);
        
        if (!empty($conditions)) {
            $this->db->where($conditions);
        }
        if (!empty($limit)) {
            $this->db->limit($limit, $offset);
        }

        if ($count === true) {
            return $this->db->get()->num_rows();
        } else {
            //$this->db->select($select);
            return $this->db->get()->result_array();
        }
    }
    
    public function getByUserID($user_id){
        return $this->getList(['user_id'=>$user_id]);
    }
    
    public function saveBatch($data) {
        $insert = [];
        if (isset($data['roles'])) {

            $records = $this->getList(['user_id' => $data['user_id']], true);
            if (empty($records)) {
                foreach ($data['roles'] as $role) {
                    $insert[] = [
                        'user_id' => $data['user_id'],
                        'role_id' => $role
                    ];
                }
                return $this->insertBatch($insert);
            } else {
                $records = $this->getListByGroup(['user_id' => $data['user_id']]);

                $roles = strpos($records[0]['roles'], ',') === false ? [$records[0]['roles']] : explode(', ', $records[0]['roles']);

                $inserts = array_diff($data['roles'], $roles);
                $removes = array_diff($roles, $data['roles']);

                if (!empty($inserts)) {
                    $insert = [];
                    foreach ($inserts as $val) {
                        $insert[] = [
                            'role_id' => $val,
                            'user_id' => $data['user_id']
                        ];
                    }
                    $this->insertBatch($insert);
                }
                
                if (!empty($removes)) {
                    $remove = [];
                    foreach ($removes as $val) {
                        $remove[] = [
                            'role_id' => $val,
                            'user_id' => $data['user_id']
                        ];
                    }
                    $this->removeBatch($remove);
                }
                return true;
            }
        }
        return false;
    }
    
    protected function getListByGroup($conditions){
        $this->db->select('GROUP_CONCAT('. $this->alias .'.role_id SEPARATOR ",") as roles ')
                ->where($conditions)
                ->from($this->table.' as '.$this->alias);

        return $this->db->get()->result_array();

    }
    
    /**
     * delete by role
     * 
     * Note: Please make this function secure and safe
     * 
     * @param type $role_id
     * @return boolean
     */
    public function deleteByRole($role_id){
        $this->db->where(['role_id'=>$role_id])->delete($this->table);
        return true;
    }

}
