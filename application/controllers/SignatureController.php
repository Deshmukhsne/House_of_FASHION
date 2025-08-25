<?php
defined('BASEPATH') or exit('No direct script access allowed');

class SignatureController extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Signature_model');
    }

    public function saveSignature()
    {
        // Get the JSON input
        $input = json_decode(file_get_contents('php://input'), true);

        // Validate input
        if (empty($input['invoice_id']) || empty($input['signature_data'])) {
            echo json_encode(['success' => false, 'message' => 'Missing required fields']);
            return;
        }

        // Save the signature
        $result = $this->Signature_model->saveSignature([
            'invoice_id' => $input['invoice_id'],
            'customer_name' => $input['customer_name'],
            'signature_data' => $input['signature_data'],
            'document_hash' => $input['document_hash'],
            'signature_timestamp' => $input['signature_timestamp']
        ]);

        if ($result) {
            echo json_encode(['success' => true, 'message' => 'Signature saved successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to save signature']);
        }
    }
}
