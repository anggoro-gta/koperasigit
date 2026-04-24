<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class MMsKategori extends CI_Model
{
    protected $id = 'id';

    public function get($table, $where=NULL) {
        $this->db->distinct();
        $this->db->select("*");
        if (!empty($where)) {
            $this->db->where($where);
        }
        $this->db->from($table);
        $this->db->order_by('id','asc');
        $result = $this->db->get();
        if ($result->num_rows() > 0) {
            return $result->result_array();
        }
    }

    function insert($table, $data){
        $this->db->insert($table, $data);
    }

    function update($table, $id, $data){
        $this->db->where($this->id, $id);
        $this->db->update($table, $data);
    }

    function delete($table, $id){
        $this->db->where($this->id, $id);
        $this->db->delete($table);
        if($this->db->affected_rows()>0){
           return true;
        }else{
           return false;
        }
    }

}