<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class OrdersController extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('OrdersModel');
        $this->load->database();
    }

    // Show orders list
    public function index() {
        // Fetch directly from orders table
        $data['orders'] = $this->db->get('orders')->result_array();
        $this->load->view('Admin/Orders', $data);
    }

    // Create invoice + items + orders
    public function create_invoice() {
        // 1. Insert invoice
        $invoiceData = [
            'invoice_no'      => $this->input->post('invoice_no'),
            'customer_name'   => $this->input->post('customer_name'),
            'customer_mobile' => $this->input->post('customer_mobile'),
            'invoice_date'    => $this->input->post('invoice_date'),
            'return_date'     => $this->input->post('return_date')
        ];
        $this->db->insert('invoices', $invoiceData);
        $invoice_id = $this->db->insert_id();

        // 2. Insert invoice_items + orders
        $items = $this->input->post('items'); // items[] array from form
        foreach ($items as $item) {
            $itemData = [
                'invoice_id' => $invoice_id,
                'item_name'  => $item['item_name'],
                'category'   => $item['category'],
                'price'      => $item['price'],
                'quantity'   => $item['quantity'],
                'total'      => $item['total'],
                'status'     => $item['status'] ?? 'Issued'
            ];
            $this->db->insert('invoice_items', $itemData);

            // ✅ Also insert into orders table
            $this->OrdersModel->insert_order_from_invoice($invoice_id, $itemData);
        }

        $this->session->set_flashdata('success', 'Invoice & orders created successfully');
        redirect('OrdersController/index');
    }

    // Update order status in both invoice_items + orders
    public function updateOrderStatus() {
        $invoice_id = $this->input->post('invoice_id');
        $item_name  = $this->input->post('item_name');
        $status     = $this->input->post('status');

        // Update in invoice_items
        $updated1 = $this->OrdersModel->update_status($invoice_id, $item_name, $status);

        // Update in orders
        $this->db->where('invoice_id', $invoice_id);
        $this->db->where('item_name', $item_name);
        $updated2 = $this->db->update('orders', ['status' => $status]);

        echo json_encode(['success' => ($updated1 && $updated2)]);
    }
}
