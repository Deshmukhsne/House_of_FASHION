<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class OrdersModel extends CI_Model {

    // Get all orders by joining invoices and invoice_items
    public function get_orders() {
        $this->db->select('inv.id as invoice_id,
                   inv.invoice_no,
                   inv.customer_name,
                   inv.customer_mobile,
                   inv.invoice_date,
                   inv.return_date,
                   itm.item_name,
                   itm.category,
                   itm.price,
                   itm.quantity,
                   itm.total,
                   itm.status,
                   p.image as product_image');   // ✅ get image from products
                $this->db->from('invoices inv');
                $this->db->join('invoice_items itm', 'inv.id = itm.invoice_id', 'left');
                $this->db->join('products p', 'p.name = itm.item_name AND p.category_id = itm.category', 'left'); 
                // join on both name + category for safety
                $query = $this->db->get();
                return $query->result_array();

    }
  public function update_status($invoice_id, $item_name, $status) {
    $this->db->where('invoice_id', $invoice_id);
    $this->db->where('item_name', $item_name);
    return $this->db->update('invoice_items', ['status' => $status]);
}


}
