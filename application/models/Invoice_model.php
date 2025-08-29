<?php
// application/models/Invoice_model.php
class Invoice_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    // Get all invoices
    public function get_invoices($limit = null, $offset = null)
    {
        $this->db->select('*');
        $this->db->from('invoices');
        $this->db->order_by('invoice_date', 'DESC');

        if ($limit !== null) {
            $this->db->limit($limit, $offset);
        }

        return $this->db->get()->result_array();
    }

    // Get invoice by ID
    public function get_invoice($id)
    {
        return $this->db->get_where('invoices', ['id' => $id])->row_array();
    }

    // Get revenue analytics data
    public function get_revenue_analytics()
    {
        $this->db->select("
            DATE_FORMAT(invoice_date, '%Y-%m') AS month,
            SUM(total_payable) AS total_revenue,
            SUM(paid_amount) AS total_paid,
            SUM(due_amount) AS total_due
        ");
        $this->db->from('invoices');
        $this->db->group_by("DATE_FORMAT(invoice_date, '%Y-%m')");
        $this->db->order_by('month', 'ASC');
        return $this->db->get()->result_array();
    }

    // Get daily revenue
    public function get_daily_revenue($date = null)
    {
        if (!$date) {
            $date = date('Y-m-d');
        }

        $this->db->select("
            SUM(total_payable) AS daily_revenue,
            SUM(paid_amount) AS daily_paid,
            SUM(due_amount) AS daily_due
        ");
        $this->db->from('invoices');
        $this->db->where('invoice_date', $date);
        return $this->db->get()->row_array();
    }

    // Create new invoice
    public function create_invoice($data)
    {
        $this->db->insert('invoices', $data);
        return $this->db->insert_id();
    }

    // Update invoice
    public function update_invoice($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('invoices', $data);
    }

    // Delete invoice
    public function delete_invoice($id)
    {
        return $this->db->delete('invoices', ['id' => $id]);
    }

    // Get total revenue
    public function get_total_revenue()
    {
        $this->db->select_sum('total_payable');
        $result = $this->db->get('invoices')->row_array();
        return $result['total_payable'] ?? 0;
    }

    // Get total paid amount
    public function get_total_paid()
    {
        $this->db->select_sum('paid_amount');
        $result = $this->db->get('invoices')->row_array();
        return $result['paid_amount'] ?? 0;
    }

    // Get total due amount
    public function get_total_due()
    {
        $this->db->select_sum('due_amount');
        $result = $this->db->get('invoices')->row_array();
        return $result['due_amount'] ?? 0;
    }

    // Search invoices
    public function search_invoices($search_term)
    {
        $this->db->like('customer_name', $search_term);
        $this->db->or_like('invoice_no', $search_term);
        $this->db->or_like('customer_mobile', $search_term);
        return $this->db->get('invoices')->result_array();
    }
    public function get_invoice_by_no($invoiceNo)
    {
        return $this->db
            ->where('invoice_no', $invoiceNo)
            ->get('invoices')   // make sure table name is correct
            ->row_array();
    }
}
