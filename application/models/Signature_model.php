<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Signature_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    /**
     * Save signature to database
     */
    public function saveSignature($data)
    {
        // Check if signature already exists for this invoice
        $existing = $this->db->get_where('invoice_signatures', ['invoice_id' => $data['invoice_id']])->row();

        if ($existing) {
            // Update existing signature
            return $this->db->where('invoice_id', $data['invoice_id'])->update('invoice_signatures', $data);
        } else {
            // Insert new signature
            return $this->db->insert('invoice_signatures', $data);
        }
    }

    /**
     * Get signature by invoice ID
     */
    public function getSignatureByInvoice($invoice_id)
    {
        return $this->db->get_where('invoice_signatures', ['invoice_id' => $invoice_id])->row();
    }

    /**
     * Verify document integrity by comparing hashes
     */
    public function verifyDocument($invoice_id, $current_hash)
    {
        $signature = $this->getSignatureByInvoice($invoice_id);

        if (!$signature) {
            return false;
        }

        return $signature->document_hash === $current_hash;
    }
}
