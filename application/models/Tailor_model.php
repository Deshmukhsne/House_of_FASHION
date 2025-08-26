<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Tailor_model extends CI_Model
{
    // Fetch all tailors
    public function get_all_tailors()
    {
        $query = $this->db->order_by('id', 'DESC')->get('tailors');
        return $query->result_array();
    }

    // Add a new tailor
    public function add_tailor($data)
    {
        return $this->db->insert('tailors', $data);
    }

    // Get tailor by ID
    public function get_tailor_by_id($id)
    {
        return $this->db->get_where('tailors', ['id' => $id])->row_array();
    }

    // Update tailor
    public function update_tailor($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('tailors', $data);
    }

    // Delete tailor
    public function delete_tailor($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('tailors');
    }
}
