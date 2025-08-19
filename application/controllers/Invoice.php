<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Invoice extends CI_Controller {

    // Removed duplicate constructor

    
    public function save_invoice() {
        
    header('Content-Type: application/json');
        $data = $this->input->post();
$total = isset($data['total_amount']) ? $data['total_amount'] : 0;

$cgst = isset($_POST['cgst']) ? $_POST['cgst'] : 0;
$sgst = isset($_POST['sgst']) ? $_POST['sgst'] : 0;

$invoiceData = [
    'bill_no'       => $data['bill_no'],
    'customer_name' => $data['customer_name'],
    'staff_name'    => $data['staff'],
    'datetime'      => $data['datetime'],
    'cgst'          => $cgst,
    'sgst'          => $sgst,
    'total_amount'  => $total
];


        $invoice_id = $this->InvoiceModel->insertInvoice($invoiceData);

        if (!empty($data['items'])) {
            foreach ($data['items'] as $item) {
                $item['invoice_id'] = $invoice_id;
                $this->InvoiceModel->insertInvoiceItem($item);
            }
        }

       echo json_encode(['status' => 'success']);

    }

    public function success() {
        $this->load->view('invoice_success');
    }

    public function __construct() {
        parent::__construct();
        $this->load->model('InvoiceModel');
    }
public function BillHistory() {
    $this->load->model('InvoiceModel');
    $data['invoices'] = $this->InvoiceModel->get_all_invoices();
    $this->load->view('admin/BillHistory', $data);
    $data['invoices'] = $this->InvoiceModel->get_all_invoices();
echo "<pre>"; print_r($data['invoices']); exit;  // Check if data is loading

}
}
