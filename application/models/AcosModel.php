<?php

class AcosModel extends MY_Model {

    protected $table = 'acos';
    protected $alias = 'acos';

    /**
     * get list
     * 
     * @param array $conditions
     * @param boolean $count
     * @param int $limit
     * @param int $offset
     * @return array $acos
     */
    public function getList($conditions = [], $count = false, $limit = 0, $offset = 0) {
        $table = $this->table;
        $alias = $this->alias;
        $this->db->from($table . ' as ' . $alias);
        $select = "";
        
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
     * get by id
     * 
     * @param int $id
     * @return array $acos
     */
    public function getByID($id){
        $conditions = [
            'id' => $id,
            
        ];
        $roles = $this->getList($conditions);
        if(!empty($roles)){
            //$this->load->model('AclModel');
        }
        
        return $roles;
    }
    
    /**
     * get by multiple id
     * 
     * @param array $ids
     * @return array $acos
     */
    public function getByMultiId($ids){
        
        $acos = $this->db->where_in('id', $ids)
                ->from($this->table)
                ->get()
                ->result_array();
        return $acos;
    }
    
    /**
     * save record
     * 
     * @param array $data
     * @return boolean
     */
    public function save($data) {
        $conditions = [
            'class'=>$data['class'],
            'method' => $data['method']
            ];
        
        if($this->getBy($conditions,true) > 0){
            $result = $this->getBy($conditions);
            $id = $result[0]['id'];
            
            return $this->update($data, $id);
        } else {
            return $this->insert($data);
        }
    }
    
}
