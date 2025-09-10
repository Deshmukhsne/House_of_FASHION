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
        $input = json_decode(file_get_contents('php://input'), true);

        if (empty($input['invoice_id']) || empty($input['signature_data'])) {
            echo json_encode(['success' => false, 'message' => 'Missing required fields']);
            return;
        }

        // Convert base64 to image file and store in uploads
        $signatureData = $input['signature_data'];
        $imageName = 'signature_' . time() . '.png';
        $imagePath = FCPATH . 'uploads/signatures/' . $imageName;

        // Create folder if not exists
        if (!is_dir(FCPATH . 'uploads/signatures/')) {
            mkdir(FCPATH . 'uploads/signatures/', 0777, true);
        }

        // Remove base64 header if exists
        $signatureData = str_replace('data:image/png;base64,', '', $signatureData);
        $signatureData = str_replace(' ', '+', $signatureData);

        file_put_contents($imagePath, base64_decode($signatureData));

        // Save both file path and base64 in DB
        $result = $this->Signature_model->saveSignature([
            'invoice_id'          => $input['invoice_id'],
            'customer_name'       => $input['customer_name'],
            'signature_data'      => $input['signature_data'], // raw base64
            'signature_image'     => 'uploads/signatures/' . $imageName, // file path
            'document_hash'       => $input['document_hash'],
            'signature_timestamp' => $input['signature_timestamp']
        ]);

        if ($result) {
            echo json_encode(['success' => true, 'message' => 'Signature saved successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to save signature']);
        }
    }
}
