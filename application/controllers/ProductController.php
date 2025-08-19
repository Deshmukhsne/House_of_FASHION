<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ProductController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Product_model');
        $this->load->model('Category_model');
    }

    // Show all products
    public function index()
    {
        $data['categories'] = $this->Category_model->get_all_categories();
        $data['products']   = $this->Product_model->get_all_products();

        $this->load->view('Admin/product_inventory', $data);
    }

    // Add new product
    public function add_product()
    {
        // Upload settings
        $config['upload_path']   = './uploads/';
        $config['allowed_types'] = 'jpg|jpeg|png|gif';
        $config['encrypt_name']  = TRUE;

        $this->load->library('upload', $config);
        $imagePath = null;

        if ($this->upload->do_upload('image')) {
            $uploadData = $this->upload->data();
            $imagePath  = 'uploads/' . $uploadData['file_name'];
        }

        $data = [
            'name'        => $this->input->post('name'),
            'price'       => $this->input->post('price'),
            'category_id' => $this->input->post('category_id'),
            'stock'       => $this->input->post('stock'),
            'status'      => $this->input->post('status'),
            'image'       => $imagePath
        ];

        $this->Product_model->insert_product($data);

        $this->session->set_flashdata('success', 'Product added successfully!');
        redirect('ProductController');
    }

    // Delete product
    public function delete_product($id)
    {
        $this->Product_model->delete_product($id);
        $this->session->set_flashdata('success', 'Product deleted successfully!');
        redirect('ProductController');
    }

    // Add new category
    public function add_category()
    {
        $name = $this->input->post('name');
        $this->Category_model->insert_category(['name' => $name]);

        $this->session->set_flashdata('success', 'Category added successfully!');
        redirect('ProductController');
    }

    // Edit product view
    public function edit_product($id)
    {
        $data['categories'] = $this->Category_model->get_all_categories();
        $data['product']    = $this->Product_model->get_product_by_id($id);

        if (empty($data['product'])) {
            show_404();
        }

        $this->load->view('Admin/edit_product', $data);
    }

    // Update product
    public function update_product()
    {
        $id = $this->input->post('product_id');

        // Upload settings
        $config['upload_path']   = './uploads/';
        $config['allowed_types'] = 'jpg|jpeg|png|gif';
        $config['encrypt_name']  = TRUE;

        $this->load->library('upload', $config);

        // Use existing image if no new one is uploaded
        $imagePath = $this->input->post('existing_image');

        if (!empty($_FILES['image']['name']) && $this->upload->do_upload('image')) {
            $uploadData = $this->upload->data();
            $imagePath  = 'uploads/' . $uploadData['file_name'];
        }

        $data = [
            'name'        => $this->input->post('name'),
            'price'       => $this->input->post('price'),
            'category_id' => $this->input->post('category_id'),
            'stock'       => $this->input->post('stock'),
            'status'      => $this->input->post('status'),
            'image'       => $imagePath
        ];

        $this->Product_model->update_product($id, $data);

        $this->session->set_flashdata('success', 'Product updated successfully!');
        redirect('ProductController');
    }
}
