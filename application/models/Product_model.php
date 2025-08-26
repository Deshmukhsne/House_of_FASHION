<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Product_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    // Insert Product
    public function insert_product($data)
    {
        return $this->db->insert('products', $data);
    }

    // Get all products with category name
    public function get_all_products()
    {
        $this->db->select('products.*, categories.name as category_name');
        $this->db->from('products');
        $this->db->join('categories', 'categories.id = products.category_id', 'left');
        return $this->db->get()->result();
    }

    // Get single product by id (with category name)
    public function get_product_by_id($id)
    {
        $this->db->select('products.*, categories.name as category_name');
        $this->db->from('products');
        $this->db->join('categories', 'categories.id = products.category_id', 'left');
        $this->db->where('products.id', $id);
        return $this->db->get()->row();
    }

    // Update product
    public function update_product($id, $data)
    {
        return $this->db->where('id', $id)->update('products', $data);
    }

    // Delete product
    public function delete_product($id)
    {
        return $this->db->delete('products', ['id' => $id]);
    }
    public function get_products_with_category()
    {
        $this->db->select('products.*, categories.name as category_name');
        $this->db->from('products');
        $this->db->join('categories', 'categories.id = products.category_id', 'left');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_total_stock_value()
    {
        // Calculate total value by multiplying price * stock for each product and summing
        $this->db->select('SUM(price * stock) as total_value', false);
        $query = $this->db->get('products');
        return $query->row()->total_value ?: 0;
    }

    public function get_total_stock_quantity()
    {
        $this->db->select_sum('stock');
        $query = $this->db->get('products');
        return $query->row()->stock;
    }
    // public function update_stock_after_sale($item_name, $quantity)
    // {
    //     // Find product by name
    //     $this->db->where('name', $item_name);
    //     $product = $this->db->get('products')->row();

    //     if ($product) {
    //         $new_stock = max(0, ($product->stock - $quantity)); // avoid negative
    //         $this->db->where('id', $product->id);
    //         $this->db->update('products', ['stock' => $new_stock]);
    //     }
    // }


    public function get_monthly_report($year, $month)
    {
        $report = array();

        // Get total orders count for the month
        $this->db->where('YEAR(invoice_date)', $year);
        $this->db->where('MONTH(invoice_date)', $month);
        $report['total_orders'] = $this->db->count_all_results('invoices');

        // Get total sales amount for the month
        $this->db->select_sum('total_amount');
        $this->db->where('YEAR(invoice_date)', $year);
        $this->db->where('MONTH(invoice_date)', $month);
        $query = $this->db->get('invoices');
        $report['total_sales'] = $query->row()->total_amount ?: 0;

        // Get top product for the month
        $this->db->select('item_name, SUM(quantity) as total_qty, SUM(total) as total_sales');
        $this->db->from('invoice_items');
        $this->db->join('invoices', 'invoice_items.invoice_id = invoices.id');
        $this->db->where('YEAR(invoices.invoice_date)', $year);
        $this->db->where('MONTH(invoices.invoice_date)', $month);
        $this->db->group_by('item_name');
        $this->db->order_by('total_qty', 'DESC');
        $this->db->limit(1);
        $topProductQuery = $this->db->get();

        $report['top_product'] = $topProductQuery->row_array() ?: [
            'item_name' => 'No sales',
            'total_qty' => 0,
            'total_sales' => 0
        ];

        // Get daily sales data for the chart
        $report['daily_sales'] = $this->get_daily_sales_data($year, $month);

        return $report;
    }

    private function get_daily_sales_data($year, $month)
    {
        // Get number of days in the month
        $days_in_month = cal_days_in_month(CAL_GREGORIAN, $month, $year);

        $labels = [];
        $data = [];

        for ($day = 1; $day <= $days_in_month; $day++) {
            $date = sprintf('%04d-%02d-%02d', $year, $month, $day);

            $this->db->select_sum('total_amount');
            $this->db->where('DATE(invoice_date)', $date);
            $query = $this->db->get('invoices');

            $amount = $query->row()->total_amount ?: 0;

            // Only show every 5th day label to avoid clutter
            $label = ($day % 5 == 0 || $day == 1 || $day == $days_in_month) ? $day : '';

            $labels[] = $label;
            $data[] = $amount;
        }

        return [
            'labels' => $labels,
            'data' => $data,
            'days_in_month' => $days_in_month
        ];
    }
    // In Product_model.php
    public function update_stock_after_sale($item_name, $quantity)
    {
        // Trim and clean the item name
        $item_name = trim($item_name);
        $quantity = (int)$quantity;

        log_message('debug', 'Attempting to update stock for: "' . $item_name . '" with quantity: ' . $quantity);

        // First, let's check what products we have in the database
        $all_products = $this->db->get('products')->result();
        log_message('debug', 'All products in DB: ' . json_encode(array_column($all_products, 'name')));

        // Try to find the product with a more flexible approach
        $this->db->like('name', $item_name);
        $product = $this->db->get('products')->row();

        if ($product) {
            log_message('debug', 'Found product: ' . $product->name . ' (ID: ' . $product->id . ') with current stock: ' . $product->stock);

            $new_stock = max(0, $product->stock - $quantity);
            log_message('debug', 'New stock will be: ' . $new_stock);

            $this->db->where('id', $product->id);
            $result = $this->db->update('products', ['stock' => $new_stock]);

            if ($result) {
                log_message('debug', 'Stock updated successfully for: ' . $product->name);
                return true;
            } else {
                log_message('error', 'Database update failed for: ' . $product->name);
                return false;
            }
        } else {
            log_message('error', 'No product found with name: "' . $item_name . '"');

            // Let's try a different approach - check if there's any similar product
            $this->db->select('name');
            $this->db->from('products');
            $this->db->like('name', $item_name, 'both');
            $similar = $this->db->get()->result();

            if (!empty($similar)) {
                log_message('debug', 'Similar product names found: ' . json_encode(array_column($similar, 'name')));
            }

            return false;
        }
    }

    public function get_by_name($name) {
        $this->db->where('name', $name);
        return $this->db->get('products')->row();
    }

    public function update_stock($id, $stock) {
        $this->db->where('id', $id);
        $this->db->update('products', array('stock' => $stock));
        return $this->db->affected_rows() > 0;
    }
}
