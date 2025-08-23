<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Vendors extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Vendor_model');
        $this->load->helper(['url', 'form']);
        $this->load->library('form_validation');
    }

    // List all vendors
    public function index()
    {
        $data['vendors'] = $this->Vendor_model->get_all_vendors();
        $this->load->view('AdminController/Vendors', $data);
    }

    // Add new vendor
    public function create()
    {
        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('mobile', 'Mobile', 'required');
        $this->form_validation->set_rules('company', 'Company', 'required');
        $this->form_validation->set_rules('address', 'Address', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('vendors/create');
        } else {
            $data = [
                'name' => $this->input->post('name'),
                'email' => $this->input->post('email'),
                'mobile' => $this->input->post('mobile'),
                'company' => $this->input->post('company'),
                'address' => $this->input->post('address')
            ];
            $this->Vendor_model->add_vendor($data);
            $this->session->set_flashdata('vendor_msg', 'Vendor added successfully!');

            redirect('AdminController/Vendors');
        }
    }

    // Edit vendor
    public function edit($id)
    {
        $data['vendor'] = $this->Vendor_model->get_vendor_by_id($id);

        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('mobile', 'Mobile', 'required');
        $this->form_validation->set_rules('company', 'Company', 'required');
        $this->form_validation->set_rules('address', 'Address', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('vendors/edit', $data);
        } else {
            $updateData = [
                'name' => $this->input->post('name'),
                'email' => $this->input->post('email'),
                'mobile' => $this->input->post('mobile'),
                'company' => $this->input->post('company'),
                'address' => $this->input->post('address')
            ];
            $this->Vendor_model->update_vendor($id, $updateData);
            // After successful update
            $this->session->set_flashdata('vendor_msg', 'Vendor updated successfully!');
            redirect('AdminController/Vendors');
        }
    }

    // Delete vendor
    public function delete($id)
    {
        $this->Vendor_model->delete_vendor($id);
        // After successful delete
        $this->session->set_flashdata('vendor_msg', 'Vendor deleted successfully!');
        redirect('AdminController/Vendors');
    }
    public function get_vendor_mobile($id)
    {
        $vendor = $this->Vendor_model->get_vendor_by_id($id);
        if ($vendor) {
            echo json_encode([
                'name'   => $vendor['name'],
                'mobile' => $vendor['mobile']
            ]);
        } else {
            echo json_encode([
                'name'   => '',
                'mobile' => ''
            ]);
        }
    }
}
