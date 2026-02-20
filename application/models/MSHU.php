<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class MSHU extends CI_Model
{

    protected $table = 't_cb_temp_shu_total';
    protected $table2 = 't_cb_temp_shu_opd';
    protected $table3 = 't_cb_temp_shu_opd_detail';
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

    public function get_opd($where = NULL)
    {
        $this->db->distinct();
        $this->db->select("*");
        if (!empty($where)) {
            $this->db->where($where);
        }
        $this->db->from($this->table2);
        $this->db->order_by('id', 'asc');
        $result = $this->db->get();
        if ($result->num_rows() > 0) {
            return $result->result_array();
        }
    }

    function insert_opd($data)
    {
        $this->db->insert($this->table2, $data);
    }

    function update_opd($id, $data)
    {
        $this->db->where($this->id, $id);
        $this->db->update($this->table2, $data);
    }

    function delete_opd($id)
    {
        $this->db->where($this->id, $id);
        $this->db->delete($this->table2);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function upsert_opd_detail_batch($data)
    {   
        if (empty($data)) return true;

        $table = 't_cb_temp_shu_opd_detail';

        $values = [];
        foreach ($data as $row) {
            $values[] = '(' .
                $this->db->escape($row['fk_shu_opd_id']) . ',' .
                $this->db->escape($row['fk_anggota_id']) . ',' .
                $this->db->escape($row['nominal']) .
            ')';
        }

        $sql = "INSERT INTO {$table} (fk_shu_opd_id, fk_anggota_id, nominal)
                VALUES " . implode(',', $values) . "
                ON DUPLICATE KEY UPDATE
                    nominal = VALUES(nominal)";

        return $this->db->query($sql);
    }


}