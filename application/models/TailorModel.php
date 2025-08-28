<?php
class TailorModel extends CI_Model
{
    public function getAllTailors()
    {
        $query = $this->db->get('tailors'); // SELECT * FROM tailors
        return $query->result_array();      // return as array
    }
}
