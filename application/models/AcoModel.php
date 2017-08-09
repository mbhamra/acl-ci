<?php

class AcoModel extends CI_Model {

    private $table = 'aco';
    private $alias = 'aco';

    public function save($data) {
        
    }
    
    public function getBy($conditions=[], $count = false){
        $query = $this->db->where($conditions)
                        ->get();
        if($count === true){
            return $query->num_rows();
        }
        return $query->result_array();
    }

}
