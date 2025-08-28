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
            'mrp'       => $this->input->post('mrp'),
            'category_id' => $this->input->post('category_id'),
            'main_category' => $this->input->post('main_category'),
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
            'mrp'       => $this->input->post('mrp'),
            'category_id' => $this->input->post('category_id'),
            'main_category' => $this->input->post('main_category'),
            'stock'       => $this->input->post('stock'),
            'status'      => $this->input->post('status'),
            'image'       => $imagePath
        ];

        $this->Product_model->update_product($id, $data);

        $this->session->set_flashdata('success', 'Product updated successfully!');
        redirect('ProductController');
    }

    public function save_invoice()
    {
        $this->load->database();
        $this->load->helper('url');
        $this->load->model('Product_model');

        // Enable detailed logging
        log_message('debug', '=== START OF save_invoice PROCESS ===');
        log_message('debug', 'POST data: ' . print_r($_POST, true));

        // Save main invoice
        $invoiceData = [
            'invoice_no'      => $this->input->post('invoiceNo'),
            'customer_name'   => $this->input->post('customerName'),
            'customer_mobile' => $this->input->post('customerMobile'),
            'invoice_date'    => $this->input->post('date'),
            'return_date'     => $this->input->post('returnDate'),
            'deposit_amount'  => $this->input->post('depositAmount'),
            'discount_amount' => $this->input->post('discountAmount'),
            'total_amount'    => $this->input->post('totalAmount'),
            'total_payable'   => $this->input->post('totalPayable'),
            'paid_amount'     => $this->input->post('paidAmount'),
            'due_amount'      => $this->input->post('dueAmount'),
            'payment_mode'    => $this->input->post('paymentMode'),
        ];

        log_message('debug', 'Invoice data: ' . print_r($invoiceData, true));

        // Start transaction for data integrity
        $this->db->trans_start();

        if ($this->db->insert('invoices', $invoiceData)) {
            $invoice_id = $this->db->insert_id();
            log_message('debug', 'Invoice created with ID: ' . $invoice_id);

            // ✅ Get items from POST (assume frontend sends array of items)
            $items = $this->input->post('items');

            log_message('debug', 'Raw items data: ' . print_r($items, true));

            if (!empty($items) && is_array($items)) {
                log_message('debug', 'Processing ' . count($items) . ' items');

                foreach ($items as $index => $item) {
                    log_message('debug', 'Item ' . $index . ' data: ' . print_r($item, true));

                    // Check if the item has the required fields
                    if (!isset($item['item_name']) || !isset($item['quantity'])) {
                        log_message('error', 'Item missing required fields: ' . print_r($item, true));
                        continue;
                    }

                    $invoice_item_data = [
                        'invoice_id' => $invoice_id,
                        'item_name'  => $item['item_name'],
                        'category'   => $item['category'] ?? '',
                        'price'      => $item['price'],
                        'quantity'   => $item['quantity'],
                        'total'      => $item['total'],
                        'status'     => 'Rented',
                        'times_rented' => 1
                    ];

                    log_message('debug', 'Inserting invoice item: ' . print_r($invoice_item_data, true));

                    // Insert into invoice_items
                    $insert_result = $this->db->insert('invoice_items', $invoice_item_data);
                    log_message('debug', 'Invoice item insert result: ' . ($insert_result ? 'SUCCESS' : 'FAILED'));

                    // 🔽 Update stock using item_name - with error handling
                    log_message('debug', 'Attempting stock update for: "' . $item['item_name'] . '" with quantity: ' . $item['quantity']);

                    $stockUpdated = $this->Product_model->update_stock_after_sale(
                        $item['item_name'],
                        $item['quantity']
                    );

                    log_message('debug', 'Stock update result: ' . ($stockUpdated ? 'SUCCESS' : 'FAILED'));

                    if (!$stockUpdated) {
                        log_message('error', 'Failed to update stock for: ' . $item['item_name']);
                    }
                }
            } else {
                log_message('error', 'No items found or items is not an array');
            }

            // Complete transaction
            $this->db->trans_complete();

            if ($this->db->trans_status() === FALSE) {
                // Transaction failed
                log_message('error', 'Transaction failed - rolling back');
                $this->db->trans_rollback();
                echo json_encode([
                    'success' => false,
                    'message' => 'Failed to save invoice and update inventory'
                ]);
            } else {
                // Transaction succeeded
                log_message('debug', 'Transaction completed successfully');
                echo json_encode([
                    'success'    => true,
                    'message'    => 'Invoice saved successfully!',
                    'invoice_no' => $invoiceData['invoice_no']
                ]);
            }
        } else {
            log_message('error', 'Failed to insert invoice');
            echo json_encode([
                'success' => false,
                'message' => 'Failed to save invoice'
            ]);
        }

        log_message('debug', '=== END OF save_invoice PROCESS ===');
    }
}
