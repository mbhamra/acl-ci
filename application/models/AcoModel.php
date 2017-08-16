<?php

class AcoModel extends MY_Model {

    protected $table = 'aco';
    protected $alias = 'aco';

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
