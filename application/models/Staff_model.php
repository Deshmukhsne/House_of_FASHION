<?php
class Staff_model extends CI_Model
{

    public function getAll()
    {
        return $this->db->get('staff')->result();
    }

    public function insert($data)
    {
        return $this->db->insert('staff', $data);
    }

    public function getById($id)
    {
        return $this->db->where('id', $id)->get('staff')->row();
    }

    public function update($id, $data)
    {
        return $this->db->where('id', $id)->update('staff', $data);
    }

    public function delete($id)
    {
        return $this->db->where('id', $id)->delete('staff');
    }
}
