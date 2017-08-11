<?php

class AcoModel extends CI_Model {

    private $table = 'aco';
    private $alias = 'aco';

    public function save($data) {
        if($this->getBy($data,true) > 0){
            $this->update($data);
        } else {
            $this->insert($data);
        }
    }
    
    /**
     * 
     * @param type $conditions = array()
     * @param type $count true = get num of rows, false = get records 
     * @return type
     */
    public function getBy($conditions=[], $count = false){
        $query = $this->db->where($conditions)
                        ->get($this->table);
        if($count === true){
            return $query->num_rows();
        }
        return $query->result_array();
    }
    
    public function insert($data){
        
    }
    
    public function update($data){
        
    }

}
