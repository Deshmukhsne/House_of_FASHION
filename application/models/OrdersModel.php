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
               p.main_category,
               itm.quantity,
               itm.total,
               itm.status,
               itm.times_rented,
               p.image as product_image');   // ✅ get image from products
    $this->db->from('invoices inv');
    $this->db->join('invoice_items itm', 'inv.id = itm.invoice_id', 'left');
    $this->db->join('products p', 'p.name = itm.item_name', 'left'); // ✅ fixed
    $query = $this->db->get();
    return $query->result_array();
}


    // ✅ Insert order record whenever invoice+items are created
    public function insert_order_from_invoice($invoice_id, $item) {
        // Get invoice details
        $invoice = $this->db->get_where('invoices', ['id' => $invoice_id])->row_array();

        // Get product image
        $product = $this->db->get_where('products', [
            'name'        => $item['item_name'],
            'category_id' => $item['category']
        ])->row_array();

        $orderData = [
            'invoice_id'     => $invoice['id'],
            'invoice_no'     => $invoice['invoice_no'],
            'customer_name'  => $invoice['customer_name'],
            'customer_mobile'=> $invoice['customer_mobile'],
            'invoice_date'   => $invoice['invoice_date'],
            'return_date'    => $invoice['return_date'],
            'item_name'      => $item['item_name'],
            'category'       => $item['category'],
            'price'          => $item['price'],
            'quantity'       => $item['quantity'],
            'total'          => $item['total'],
            'status'         => $item['status'] ?? 'Issued',
            'times_rented'   => $item['times_rented'],
            'product_image'  => $product['image'] ?? null
        ];

        return $this->db->insert('orders', $orderData);
    }

    // ✅ Update status (and increment times_rented if Rented)
    public function update_status($invoice_id, $item_name, $status)
    {
        if ($status == 'Rented') {
            $this->db->set('times_rented', 'times_rented + 1', FALSE);
        }

        $this->db->where('invoice_id', $invoice_id);
        $this->db->where('item_name', $item_name);
        $this->db->update('invoice_items', ['status' => $status]);

        return $this->db->affected_rows() > 0;
    }

    // ✅ Get all products that need dry cleaning (returned clothes only)
    public function get_all_products_for_drycleaning()
    {
        $this->db->select('*');
        $this->db->from('invoice_items');
        $this->db->where('status', 'Returned');
        $this->db->where('category !=', 'Accessories'); // exclude accessories
        return $this->db->get()->result_array();
    }
    // OrdersModel.php
public function get_product_sales()
{
    $this->db->select('category, item_name, COUNT(*) as items_rented, SUM(price) as revenue');
    $this->db->from('invoice_items');
    $this->db->group_by('item_name');
    $query = $this->db->get();
    return $query->result();
}

}
