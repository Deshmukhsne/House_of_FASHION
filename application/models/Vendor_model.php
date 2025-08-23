<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Vendor_model extends CI_Model
{

    // Fetch all vendors
    public function get_all_vendors()
    {
        $query = $this->db->order_by('id', 'DESC')->get('vendors');
        return $query->result_array();
    }

    // Add a new vendor
    public function add_vendor($data)
    {
        return $this->db->insert('vendors', $data);
    }

    // Get vendor by ID
    public function get_vendor_by_id($id)
    {
        return $this->db->get_where('vendors', ['id' => $id])->row_array();
    }

    // Update vendor
    public function update_vendor($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('vendors', $data);
    }

    // Delete vendor
    public function delete_vendor($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('vendors');
    }
}
