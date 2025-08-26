<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Tailor_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    // Get all tailors
    public function get_all_tailors()
    {
        return $this->db->get('tailors')->result_array();
    }

    // Get tailor by ID
    public function get_tailor_by_id($id)
    {
        return $this->db->get_where('tailors', array('id' => $id))->row_array();
    }

    // Create new tailor
    public function create_tailor($data)
    {
        $this->db->insert('tailors', $data);
        return $this->db->insert_id();
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

    // Search tailors
    public function search_tailors($search_term)
    {
        $this->db->like('name', $search_term);
        $this->db->or_like('email', $search_term);
        $this->db->or_like('mobile', $search_term);
        $this->db->or_like('specialization', $search_term);
        $this->db->or_like('address', $search_term);
        return $this->db->get('tailors')->result_array();
    }
}
