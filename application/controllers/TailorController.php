<?php
defined('BASEPATH') or exit('No direct script access allowed');

class TailorController extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->model('TailorModel');
        $this->load->library('session');
    }

    public function save()
    {
        $post = $this->input->post();

        $data = array(
            'product_id'          => $post['invoice_item_id'],
            'tailor_id'           => $post['tailor_id'],
            'tailor_name'         => $post['tailor_name'],
            'alteration_type'     => $post['alteration_type'],
            'return_date'         => $post['return_date'],
            'tailor_instructions' => $post['tailor_instructions'],
            'status'              => $post['product_status'] ?? 'Tailoring'
        );

        $result = $this->TailorModel->saveTailorHistory($data);

        if ($result) {
            // ✅ Update invoice_items.status to "Tailoring"
            $this->db->where('id', $post['invoice_item_id']);
            $this->db->update('invoice_items', ['status' => 'Tailoring']);

            $this->session->set_flashdata('tailor_success', 'Product forwarded to tailor successfully!');
        } else {
            $this->session->set_flashdata('tailor_error', 'Failed to forward product to tailor.');
        }

        redirect('AdminController/tailor_history'); // adjust as per your route
    }


    public function form()
    {
        $this->load->view('Admin/Orders');
    }
    public function update_status()
    {
        // Load the model
        $this->load->model('TailorModel');

        // Get POST data
        $id = $this->input->post('id');
        $status = $this->input->post('status');

        // Update status via model
        $this->TailorModel->updateStatus($id, $status);

        // Redirect back to history page
        redirect('AdminController/tailor_history');
    }
}
