<?php

/**
 * Description of MY_Model
 *
 * @author Manmohan
 */
class MY_Model extends CI_Model {
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
    
    protected function insert($insert){
        
        return $this->insertBatch([$insert]);
    }
    
    protected function insertBatch($insert){
        if($this->db->insert_batch($this->table, $insert)){
            log_message('debug',$this->db->last_query());
            $this->insert_id = $this->db->insert_id();
            return true;
        } else {
            return false;
        }
    }
    
    protected function update($update, $id){
        $condition = ['ID'=>$id];
        
        if($this->db->update($this->table, $update, $condition)){
            log_message('debug',$this->db->last_query());
            return true;
        } else {
            log_message('debug','Table- ' . $this->table . ' Record not updated');
            log_message('debug',$this->db->last_query());
            return false;
        }
    }
    
    protected function removeBatch($conditions){
        log_message('info', 'Starting remove records in batch -Table: ' . $this->table);
        foreach($conditions AS $condition){
            
            $this->db->delete($this->table, $condition);
            log_message('debug',$this->db->last_query());
            $this->db->reset_query();
        }
        log_message('info','Removed records in batch -Table: ' . $this->table);
    }
}
