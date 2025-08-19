<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Report_model extends CI_Model
{
    public function get_daily_sales($date)
    {
        $report = array();

        // Get total orders count
        $this->db->where('DATE(invoice_date)', $date);
        $report['total_orders'] = $this->db->count_all_results('invoices');

        // Get total sales amount
        $this->db->select_sum('total_amount');
        $this->db->where('DATE(invoice_date)', $date);
        $query = $this->db->get('invoices');
        $report['total_sales'] = $query->row()->total_amount ?: 0;



        // Get hourly sales data
        $report['hourly_sales'] = $this->get_hourly_sales($date);

        // Get top product
        $this->db->select('item_name, SUM(quantity) as total_qty, SUM(total) as total_sales');
        $this->db->from('invoice_items');
        $this->db->join('invoices', 'invoice_items.invoice_id = invoices.id');
        $this->db->where('DATE(invoices.invoice_date)', $date);
        $this->db->group_by('item_name');
        $this->db->order_by('total_qty', 'DESC'); // for quantity

        $this->db->limit(1);
        $topProductQuery = $this->db->get();

        $report['top_product'] = $topProductQuery->row_array() ?: [
            'item_name' => 'No sales',
            'total_qty' => 0,
            'total_sales' => 0
        ];


        return $report;
    }

    private function get_hourly_sales($date)
    {
        $hours = [];
        $sales = [];

        for ($i = 8; $i <= 20; $i += 2) {
            $start_time = str_pad($i, 2, '0', STR_PAD_LEFT) . ':00:00';
            $end_time = str_pad($i + 2, 2, '0', STR_PAD_LEFT) . ':00:00';

            $this->db->select_sum('total_amount');
            $this->db->where('invoice_date', $date);
            $this->db->where('TIME(created_at) >=', $start_time);
            $this->db->where('TIME(created_at) <', $end_time);
            $query = $this->db->get('invoices');

            $amount = $query->row()->total_amount ?: 0;

            // Format hour labels correctly
            $hour_label = ($i < 12) ? $i . ' AM' : (($i == 12) ? '12 PM' : ($i - 12) . ' PM');
            $hours[] = $hour_label;
            $sales[] = $amount;
        }

        return [
            'hours' => $hours,
            'sales' => $sales
        ];
    }
    public function get_monthly_report($year, $month)
    {
        $report = array();

        // Get total orders count for the month
        $this->db->where('YEAR(invoice_date)', $year);
        $this->db->where('MONTH(invoice_date)', $month);
        $report['total_orders'] = $this->db->count_all_results('invoices');

        // Get total sales amount for the month
        $this->db->select_sum('total_payable');
        $this->db->where('YEAR(invoice_date)', $year);
        $this->db->where('MONTH(invoice_date)', $month);
        $query = $this->db->get('invoices');
        $report['total_sales'] = $query->row()->total_payable ?: 0;

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
        $days_in_month = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        $labels = [];
        $data = array_fill(0, $days_in_month, 0); // Initialize all days with 0

        // Get all sales data for the month in one query (more efficient)
        $this->db->select('DAY(invoice_date) as day, SUM(total_payable) as daily_total');
        $this->db->where('YEAR(invoice_date)', $year);
        $this->db->where('MONTH(invoice_date)', $month);
        $this->db->group_by('DAY(invoice_date)');
        $query = $this->db->get('invoices');
        $result = $query->result_array();

        // Populate the data array with actual sales
        foreach ($result as $row) {
            $day = (int)$row['day'];
            $data[$day - 1] = (float)$row['daily_total']; // days are 1-based, array is 0-based
        }

        // Create labels (1, 2, 3...)
        $labels = range(1, $days_in_month);

        return [
            'labels' => $labels,
            'data' => $data,
            'days_in_month' => $days_in_month
        ];
    }
}
