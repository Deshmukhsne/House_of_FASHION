<?php
defined('BASEPATH') or exit('No direct script access allowed');

class DrycleaningController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('DryCleaning_model');
        $this->load->model('Vendor_model');
        $this->load->helper(['url', 'form']);
        $this->load->library('session');
    }

    // Show forward dry cleaning form
    public function forward($invoice_item_id)
    {
        $this->load->model('DryCleaning_model');
        $this->load->model('Vendor_model');

        // Fetch product info for this invoice item
        $product = $this->DryCleaning_model->get_product_by_invoice_item($invoice_item_id);

        $vendors = $this->Vendor_model->get_all_vendors();

        $data = [
            'product' => $product,
            'vendors' => $vendors,
            'invoice_item_id' => $invoice_item_id
        ];

        $this->load->view('Admin/DryCleaning_Forward', $data);
    }

    // Save forward dry cleaning form - UPDATED
    public function save()
    {
        $post = $this->input->post();

        $data = [
            'vendor_name'     => $post['vendor_name'],
            'vendor_mobile'   => $post['vendor_mobile'],
            'product_name'    => $post['product_name'],
            'product_status'  => $post['product_status'] ?? 'In Cleaning',
            'forward_date'    => $post['forward_date'],
            'return_date'     => $post['return_date'], // Use return_date instead of expected_return
            'status'          => 'Forwarded',
            'cleaning_notes'  => $post['cleaning_notes'] ?? null,
            'created_at'      => date('Y-m-d H:i:s'),
            'updated_at'      => date('Y-m-d H:i:s')
        ];

        if ($this->DryCleaning_model->insert_forwarding($data)) {
            // Update the original invoice item status to "Dry Clean"
            $this->load->model('OrdersModel');
            $this->OrdersModel->update_order_status($post['invoice_item_id'], 'Dry Clean');

            $this->session->set_flashdata('success', 'Dry cleaning forwarded successfully.');
        } else {
            $this->session->set_flashdata('error', 'Failed to forward dry cleaning.');
        }

        redirect('admin/orders');
    }

    // View all dry cleaning records
    public function index()
    {
        $data['drycleaning_records'] = $this->DryCleaning_model->get_all_drycleaning();
        $this->load->view('Admin/drycleaning_list', $data);
    }

    // Update dry cleaning status
    public function update_dryclean_status()
    {
        $id = $this->input->post('id');
        $status = $this->input->post('status');

        if ($this->DryCleaning_model->update_status($id, $status)) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false]);
        }
    }
    // public function index()
    // {
    //     $data['drycleaning_data'] = $this->Drycleaning_model->get_all();
    //     $this->load->view('drycleaning_status', $data);
    // }

    public function update_status()
    {
        $id = $this->input->post('id');
        $status = $this->input->post('status');

        $result = $this->Drycleaning_model->update_status($id, $status);

        echo json_encode(['success' => $result]);
    }

    public function delete_drycleaning()
    {
        $id = $this->input->post('id');
        $result = $this->Drycleaning_model->delete_record($id);

        echo json_encode(['success' => $result]);
    }
}
