<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class OrdersController extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('OrdersModel');
    }

    public function index() {
        $data['orders'] = $this->OrdersModel->get_orders();
        $this->load->view('Admin/Orders', $data);
    }
    
    public function updateOrderStatus() {
    $invoice_id = $this->input->post('invoice_id');
    $item_name  = $this->input->post('item_name');
    $status     = $this->input->post('status');

    $this->load->model('OrdersModel');
    $updated = $this->OrdersModel->update_status($invoice_id, $item_name, $status);

    echo json_encode(['success' => $updated]);
}

}
