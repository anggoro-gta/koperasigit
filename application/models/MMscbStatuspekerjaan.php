<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class MMscbStatuspekerjaan extends CI_Model
{

    protected $table = 'ms_cb_status_pekerjaan';
    protected $id = 'id';

    public function get($where = NULL)
    {
        $this->db->distinct();
        $this->db->select("*");
        if (!empty($where)) {
            $this->db->where($where);
        }
        $this->db->from($this->table);
        $this->db->order_by('id', 'asc');
        $result = $this->db->get();
        if ($result->num_rows() > 0) {
            return $result->result_array();
        }
    }

    function insert($data)
    {
        $this->db->insert($this->table, $data);
    }

    function update($id, $data)
    {
        $this->db->where($this->id, $id);
        $this->db->update($this->table, $data);
    }

    function delete($id)
    {
        $this->db->where($this->id, $id);
        $this->db->delete($this->table);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
}
