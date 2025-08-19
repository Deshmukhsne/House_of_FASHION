<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Reports extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Report_model');
        // Check admin login here if needed
    }

    public function daily_sales($date = null)
    {
        // Use provided date or default to today
        $date = $date ? $date : date('Y-m-d');

        // Get report data
        $data['report'] = $this->Report_model->get_daily_sales($date);
        $data['report_date'] = $date;

        // Load view
        $this->load->view('admin/daily_sales_report', $data);
    }
}