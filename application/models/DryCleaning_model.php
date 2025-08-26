<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DryCleaning_model extends CI_Model {

    public function insert($data)
    {
        $this->db->insert('drycleaning_status', $data);
        return $this->db->affected_rows() > 0;
    }

    public function get_all()
    {
        $this->db->order_by('id', 'DESC');
        return $this->db->get('drycleaning_status')->result();
    }

    public function update_status($id, $status)
    {
        $this->db->where('id', $id);
        $this->db->update('drycleaning_status', [
            'status' => $status,
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        return $this->db->affected_rows() > 0;
    }
    public function delete($id)
{
    $this->db->where('id', $id);
    return $this->db->delete('drycleaning_status'); 
   
}

public function get_by_id($id) {
    $this->db->where('id', $id);
    return $this->db->get('drycleaning_status')->row();
}
}
