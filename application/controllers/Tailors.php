<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Tailors extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Tailor_model');
    }

    // List all tailors
    // List all tailors
    // List all tailors
    public function index()
    {
        $data['tailors'] = $this->Tailor_model->get_all_tailors();
        $this->load->view('Admin/Tailors', $data);
    }


    // Create new tailor
    // Create Tailor
    public function create()
    {
        $email = $this->input->post('email');
        $exists = $this->db->get_where('tailors', ['email' => $email])->row();

        if ($exists) {
            $this->session->set_flashdata('swal', [
                'type' => 'error',
                'title' => 'Duplicate Email',
                'text' => 'This email is already registered!'
            ]);
        } else {
            $data = [
                'name' => $this->input->post('name'),
                'email' => $this->input->post('email'),
                'mobile' => $this->input->post('mobile'),
                'specialization' => $this->input->post('specialization'),
                'shop_address' => $this->input->post('shop_address')
            ];
            $this->db->insert('tailors', $data);
            $this->session->set_flashdata('swal', [
                'type' => 'success',
                'title' => 'Success',
                'text' => 'Tailor added successfully!'
            ]);
        }
        redirect('AdminController/Tailors');
    }

    // Update Tailor
    public function edit($id)
    {
        $data = [
            'name' => $this->input->post('name'),
            'email' => $this->input->post('email'),
            'mobile' => $this->input->post('mobile'),
            'specialization' => $this->input->post('specialization'),
            'shop_address' => $this->input->post('shop_address')
        ];
        $this->db->where('id', $id)->update('tailors', $data);

        $this->session->set_flashdata('swal', [
            'type' => 'success',
            'title' => 'Updated',
            'text' => 'Tailor updated successfully!'
        ]);

        redirect('AdminController/Tailors');
    }

    // Delete Tailor
    public function delete($id)
    {
        $this->db->delete('tailors', ['id' => $id]);

        $this->session->set_flashdata('swal', [
            'type' => 'success',
            'title' => 'Deleted',
            'text' => 'Tailor deleted successfully!'
        ]);

        redirect('AdminController/Tailors');
    }
}
