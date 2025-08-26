<?php
defined('BASEPATH') or exit('No direct script access allowed');

class TailorController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Tailor_model');
        $this->load->helper(['url', 'form']);
        $this->load->library('session');
    }

    // Display all tailors
    public function index()
    {
        $data['tailors'] = $this->Tailor_model->get_all_tailors();
        $this->load->view('tailor_management', $data);
    }

    // Add new tailor
    public function add_tailor()
    {
        if ($this->input->post()) {
            $data = [
                'name'           => $this->input->post('name'),
                'email'          => $this->input->post('email'),
                'phone'          => $this->input->post('phone'),
                'address'        => $this->input->post('address'),
                'specialization' => $this->input->post('specialization')
            ];
            $this->Tailor_model->add_tailor($data);
            $this->session->set_flashdata('success', 'Tailor added successfully!');
        }
        redirect('AdminController/Tailors');
    }

    // Edit tailor
    public function edit_tailor($id)
    {
        $tailor = $this->Tailor_model->get_tailor_by_id($id);
        if (!$tailor) {
            show_404();
        }

        if ($this->input->post()) {
            $data = [
                'name'           => $this->input->post('name'),
                'email'          => $this->input->post('email'),
                'phone'          => $this->input->post('phone'),
                'address'        => $this->input->post('address'),
                'specialization' => $this->input->post('specialization')
            ];
            $this->Tailor_model->update_tailor($id, $data);
            $this->session->set_flashdata('success', 'Tailor updated successfully!');
            redirect('TailorController');
        } else {
            $data['tailor'] = $tailor;
            $this->load->view('AdminController/Tailors', $data);
        }
    }

    // Delete tailor
    public function delete_tailor($id)
    {
        $tailor = $this->Tailor_model->get_tailor_by_id($id);
        if ($tailor) {
            $this->Tailor_model->delete_tailor($id);
            $this->session->set_flashdata('success', 'Tailor deleted successfully!');
        }
        redirect('AdminController/Tailors');
    }
}
