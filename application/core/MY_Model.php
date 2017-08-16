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
    
    public function insert($data){
        if(isset($data['id'])) unset($data['id']);
        try{
            $this->db->insert($this->table, $data);
            return true;
        } catch(Exception $err){
            log_message('error','inserting in '.$this->table.' table and error occur - ' . $err->getMessage());
            return false;
        }
    }
    
    public function update($data){
        $id = $data['id'];
        unset($data['id']);
        
        try{
            $this->db->where('id',$id)->update($this->table, $data);
            return true;
        } catch(Exception $err){
            log_message('error','updating ' . $this->table . ' table error - ' . $err->getMessage());
            return false;
        }
        
    }
}
