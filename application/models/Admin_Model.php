<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin_Model extends CI_Model
{

    public function insert_staff($data)
    {
        return $this->db->insert('users', $data);
    }

    public function get_all_staffs($search = null, $role = null)
    {
        if ($search) {
            $this->db->like('name', $search);
        }
        if ($role) {
            $this->db->where('role', $role);
        }
        return $this->db->get('users')->result();
    }

    public function get_staff_by_id($id)
    {
        return $this->db->get_where('users', ['id' => $id])->row();
    }

    public function update_staff($id, $data)
    {
        return $this->db->where('id', $id)->update('users', $data);
    }

    public function delete_staff($id)
    {
        return $this->db->delete('users', ['id' => $id]);
    }

    public function get_by_username($username)
    {
        return $this->db->get_where('users', ['username' => $username])->row();
    }



    //Admin Profile 


    public function validate_user($username, $password)
    {
        $this->db->where('username', $username);
        $query = $this->db->get('users');

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $user) {
                // Check for hashed password
                if (password_verify($password, $user->password)) {
                    return $user;
                }

                // Check for plain text password
                if ($user->password === $password) {
                    return $user;
                }
            }
        }

        return false;
    }


    public function get_user_by_id($id)
    {
        return $this->db->get_where('users', ['id' => $id])->row();
    }

    // public function update_password($id, $newPassword)
    // {
    //     $hashedPassword = md5($newPassword); // again, prefer bcrypt if possible
    //     $this->db->where('id', $id);
    //     $this->db->update('users', ['password' => $hashedPassword]);
    // }
    public function update_password($id, $newPassword)
    {
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT); // bcrypt
        $this->db->where('id', $id);
        return $this->db->update('users', ['password' => $hashedPassword]);
    }


    // Fetch category-wise sales summary


    // application/models/Admin_Model.php (or create a new Invoice_model.php)
    public function get_total_deposits()
    {
        $this->db->select_sum('deposit_amount');
        $query = $this->db->get('invoices');
        return $query->row()->deposit_amount ?: 0;
    }
    // application/models/Admin_Model.php
    public function get_total_revenue()
    {
        $this->db->select_sum('total_payable');
        $query = $this->db->get('invoices');
        return $query->row()->total_payable ?: 0;
    }
   public function get_category_wise_sales()
{
    $this->db->select('
        c.name as category_name,
        p.name,
        p.mrp,
        p.price,
        COUNT(i.id) as times_rented,
        (COUNT(i.id) * p.price) as total_revenue
    ');
    $this->db->from('invoice_items i');
    $this->db->join('products p', 'i.item_name = p.name', 'left');
    $this->db->join('categories c', 'p.category_id = c.id', 'left');
    $this->db->group_by('p.id'); // Group by product
    $this->db->order_by('c.name, p.name', 'ASC'); // Optional sorting

    $query = $this->db->get();
    return $query->result_array();
}

    public function get_revenue_analytics($period = 'monthly')
    {
        $this->db->select([
            'DATE(invoice_date) as date',
            'SUM(total_payable) as total_revenue',
            'COUNT(id) as total_invoices'
        ]);

        // Default to last 30 days
        $this->db->where('invoice_date >=', date('Y-m-d', strtotime('-30 days')));
        $this->db->group_by('DATE(invoice_date)');
        $this->db->order_by('date', 'ASC');

        $query = $this->db->get('invoices');
        $results = $query->result_array();

        // Format data for Chart.js
        $data = [
            'labels' => [],
            'datasets' => [
                'total_revenue' => [],
                'total_invoices' => []
            ]
        ];

        foreach ($results as $row) {
            $data['labels'][] = date('d M', strtotime($row['date']));
            $data['datasets']['total_revenue'][] = $row['total_revenue'];
            $data['datasets']['total_invoices'][] = $row['total_invoices'];
        }

        return $data;
    }



    public function get_payment_method_stats()
    {
        $this->db->select([
            'payment_mode',
            'SUM(total_payable) as amount',
            'COUNT(id) as count'
        ]);

        $this->db->from('invoices');
        $this->db->where('invoice_date >=', date('Y-m-d', strtotime('-30 days')));
        $this->db->group_by('payment_mode');

        $query = $this->db->get();
        $results = $query->result_array();

        $data = [
            'labels' => [],
            'amounts' => [],
            'counts' => []
        ];

        foreach ($results as $row) {
            $data['labels'][] = ucfirst($row['payment_mode']);
            $data['amounts'][] = $row['amount'];
            $data['counts'][] = $row['count'];
        }

        return $data;
    }
    public function get_recent_transactions($limit = 5)
    {
        $this->db->select('invoice_no, total_amount, paid_amount, due_amount, payment_mode, invoice_date');
        $this->db->from('invoices');
        $this->db->order_by('id', 'DESC');
        $this->db->limit($limit);
        return $this->db->get()->result();
    }
}
