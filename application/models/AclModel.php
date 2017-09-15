<?php

class AclModel extends MY_Model {

    protected $table = 'acl';
    protected $alias = 'a';

    /**
     * get list
     * 
     * @param array $conditions
     * @param boolean $count
     * @param int $limit
     * @param int $offset
     * @return array $acl
     */
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
    
    /**
     * get by role id
     * 
     * @param int $role_id
     * @return array
     */
    public function getByRole($role_id){
        return $this->getList(['role_id'=>$role_id]);
    }
    
    /**
     * save data in batch
     * 
     * @param array $data
     * @return boolean
     */
    public function saveBatch($data) {
        $insert = [];
        if (isset($data['acos'])) {

            $records = $this->getList(['role_id' => $data['role_id']], true);
            if (empty($records)) {
                foreach ($data['acos'] AS $aco) {
                    $insert[] = [
                        'role_id' => $data['role_id'],
                        'aco_id' => $aco
                    ];
                }
                return $this->insertBatch($insert);
            } else {
                $records = $this->getListByGroup(['role_id' => $data['role_id']]);

                $acos = strpos($records[0]['acos'], ',') === false ? [$records[0]['acos']] : explode(', ', $records[0]['acos']);

                $inserts = array_diff($data['acos'], $acos);
                $removes = array_diff($acos, $data['acos']);

                if (!empty($inserts)) {
                    $insert = [];
                    foreach ($inserts as $val) {
                        $insert[] = [
                            'role_id' => $data['role_id'],
                            'aco_id' => $val
                        ];
                    }
                    $this->insertBatch($insert);
                }
                if (!empty($removes)) {
                    $remove = [];
                    foreach ($removes as $val) {
                        $remove[] = [
                            'role_id' => $data['role_id'],
                            'aco_id' => $val
                        ];
                    }
                    $this->removeBatch($remove);
                }
                return true;
            }
        }
        return false;
    }
    
    /**
     * get list by group
     * 
     * @param array $conditions
     * @return array
     */
    protected function getListByGroup($conditions){
        $this->db->select('GROUP_CONCAT('. $this->alias .'.aco_id SEPARATOR ",") as acos ')
                ->where($conditions)
                ->from($this->table.' as '.$this->alias);

        return $this->db->get()->result_array();

    }
    
    /**
     * get by multiple roles
     * 
     * @param array $roles
     * @return array
     */
    public function getByRoles($roles){
        if(empty($roles)){
            return [];
        }
        $alias = $this->alias;
        $acl = $this->db->distinct('acos.class, acos.method, acos.display_name')
                ->where_in('role_id',$roles)
                ->from($this->table. ' as ' . $this->alias)
                ->join('acos', 'acos.id = '.$this->alias.'.aco_id','inner')
                ->get()
                ->result_array();
        
        return $acl;
    }

    /**
     * delete by role
     * 
     * Note: Please make this function secure and safe
     * 
     * @param int $role_id
     * @return boolean
     */
    public function deleteByRole($role_id){
        $this->db->where(['role_id' => $role_id])->delete($this->table);
        return true;
    }
}
