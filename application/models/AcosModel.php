<?php

class AcosModel extends MY_Model {

    protected $table = 'acos';
    protected $alias = 'acos';

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

    public function getByID($id){
        $conditions = [
            'id' => $id,
            
        ];
        $roles = $this->getList($conditions);
        if(!empty($roles)){
            $this->load->model('AclModel');
            //$roles[0]['Permission'] = $this->RolePermissionModel->getByRoleID($id);
        }
        
        return $roles;
    }
    
    public function save($data) {
        $conditions = [
            'class'=>$data['class'],
            'method' => $data['method']
            ];
        
        if($this->getBy($conditions,true) > 0){
            $result = $this->getBy($conditions);
            $data['id'] = $result[0]['id'];
            return $this->update($data);
        } else {
            return $this->insert($data);
        }
    }
    
}
