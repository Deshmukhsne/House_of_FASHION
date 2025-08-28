<?php
defined('BASEPATH') or exit('No direct script access allowed');

class DryCleaning_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    // Insert dry cleaning forward record - UPDATED FOR YOUR DATABASE STRUCTURE
    public function insert_forwarding($data)
    {
        // Map the data to match your database columns
        $db_data = [
            'vendor_name' => $data['vendor_name'],
            'vendor_mobile' => $data['vendor_mobile'],
            'product_name' => $data['product_name'],
            'product_status' => $data['product_status'],
            'forward_date' => $data['forward_date'],
            'return_date' => $data['return_date'],
            'status' => $data['status'],
            'cleaning_notes' => $data['cleaning_notes'],
            'created_at' => $data['created_at'],
            'updated_at' => $data['updated_at']
        ];

        return $this->db->insert('drycleaning', $db_data);
    }

    // Get product by invoice item ID
    public function get_product_by_invoice_item($invoice_item_id)
    {
        $this->db->select('id as invoice_item_id, item_name, status');
        $this->db->from('invoice_items');
        $this->db->where('id', $invoice_item_id);
        $query = $this->db->get();
        return $query->row_array();
    }
    public function get_by_id($id)
    {
        return $this->db->where('id', $id)->get('drycleaning')->row_array();
    }

    // Get all dry cleaning records
    public function get_all_drycleaning()
    {
        $this->db->order_by('created_at', 'DESC');
        return $this->db->get('drycleaning')->result_array();
    }

    // // Update dry cleaning status
    // public function update_status($id, $status)
    // {
    //     $this->db->where('id', $id);
    //     return $this->db->update('drycleaning', array(
    //         'status' => $status,
    //         'updated_at' => date('Y-m-d H:i:s')
    //     ));
    // }

    public function get_all()
    {
        return $this->db->get('drycleaning')->result();
    }

    public function update_status($id, $status)
    {
        return $this->db->where('id', $id)
            ->update('drycleaning', ['status' => $status]);
    }

    public function delete_record($id)
    {
        return $this->db->where('id', $id)->delete('drycleaning');
    }
}
