<?php
defined('BASEPATH') or exit('No direct script access allowed');

class OrdersController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('OrdersModel');
        $this->load->database();
        $this->load->library('session');
    }

    // Show orders list
    public function index()
    {
        $data['orders'] = $this->OrdersModel->get_orders();
        $this->load->view('Admin/Orders', $data);
    }

    // Create invoice + items + orders
    public function create_invoice()
    {
        // Insert invoice
        $invoiceData = [
            'invoice_no'      => $this->input->post('invoice_no'),
            'customer_name'   => $this->input->post('customer_name'),
            'customer_mobile' => $this->input->post('customer_mobile'),
            'invoice_date'    => $this->input->post('invoice_date'),
            'return_date'     => $this->input->post('return_date')
        ];
        $this->db->insert('invoices', $invoiceData);
        $invoice_id = $this->db->insert_id();

        // Insert invoice_items + orders
        $items = $this->input->post('items'); // Expecting array
        if (!empty($items)) {
            foreach ($items as $item) {
                $itemData = [
                    'invoice_id'   => $invoice_id,
                    'item_name'    => $item['item_name'],
                    'category'     => $item['category'],
                    'price'        => $item['price'],
                    'quantity'     => $item['quantity'],
                    'total'        => $item['total'],
                    'times_rented' => isset($item['times_rented']) ? $item['times_rented'] : 0,
                    'status'       => isset($item['status']) ? $item['status'] : 'Issued'
                ];
                $this->db->insert('invoice_items', $itemData);

                // Also insert into orders table
                $this->OrdersModel->insert_order_from_invoice($invoice_id, $itemData);
            }
        }

        $this->session->set_flashdata('success', 'Invoice & orders created successfully');
        redirect('OrdersController/index');
    }

    // Update order status in both invoice_items + orders
    public function updateOrderStatus()
    {
        $invoice_id = $this->input->post('invoice_id');
        $item_name  = $this->input->post('item_name');
        $status     = $this->input->post('status');

        $updated1 = $this->OrdersModel->update_status($invoice_id, $item_name, $status);

        // Update in orders
        if ($status == 'Rented') {
            $this->db->set('times_rented', 'times_rented + 1', FALSE);
        }
        $this->db->where('invoice_id', $invoice_id);
        $this->db->where('item_name', $item_name);
        $updated2 = $this->db->update('orders', ['status' => $status]);

        echo json_encode(['success' => ($updated1 && $updated2)]);
    }

    // Sales report
    public function productSales()
    {
        $data['sales'] = $this->OrdersModel->get_product_sales();
        $this->load->view('product_sales', $data);
    }
    
}
