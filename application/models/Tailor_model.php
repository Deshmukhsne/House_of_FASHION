<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Tailor_model extends CI_Model
{

    private $table = "tailors";

    public function get_all_tailors()
    {
        return $this->db->get($this->table)->result_array();
    }

    public function get_tailor($id)
    {
        return $this->db->get_where($this->table, ['id' => $id])->row_array();
    }

    public function insert_tailor($data)
    {
        return $this->db->insert($this->table, $data);
    }

    public function update_tailor($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update($this->table, $data);
    }

    public function delete_tailor($id)
    {
        return $this->db->delete($this->table, ['id' => $id]);
    }
}
