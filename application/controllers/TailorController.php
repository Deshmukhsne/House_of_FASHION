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
        $data = array(
            'product_id'         => $this->input->post('invoice_item_id'),
            'tailor_id'          => $this->input->post('tailor_id'),
            'tailor_name'        => $this->input->post('tailor_name'),
            'alteration_type'    => $this->input->post('alteration_type'),
            'return_date'        => $this->input->post('return_date'),
            'tailor_instructions' => $this->input->post('tailor_instructions'),
            'status'             => $this->input->post('product_status')
        );

        $result = $this->TailorModel->saveTailorHistory($data);

        if ($result) {
            $this->session->set_flashdata('tailor_success', 'Product forwarded to tailor successfully!');
        } else {
            $this->session->set_flashdata('tailor_error', 'Failed to forward product to tailor.');
        }

        redirect('TailorController/form'); // adjust as per your route
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
