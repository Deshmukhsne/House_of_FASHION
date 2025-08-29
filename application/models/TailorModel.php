<?php
class TailorModel extends CI_Model
{
    public function getAllTailors()
    {
        $query = $this->db->get('tailors'); // SELECT * FROM tailors
        return $query->result_array();      // return as array
    }
    public function saveTailorHistory($data)
    {
        return $this->db->insert('product_tailor_history', $data);
    }
    public function getAllTailorHistory()
    {
        return $this->db->get('product_tailor_history')->result();
    }
    public function updateStatus($id, $status)
    {
        $data = array(
            'status' => $status
        );

        $this->db->where('id', $id);
        $this->db->update('product_tailor_history', $data);
    }
}
