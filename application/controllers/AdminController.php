<?php
defined('BASEPATH') or exit('No direct script access allowed');

class AdminController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->helper(['form', 'url']);
        $this->load->library(['session', 'form_validation']);
        $this->load->model('Login_Model');
        $this->load->model('Admin_Model');
        $this->load->model('Product_model');
        $this->load->model('Report_model');
        $this->load->model('DryCleaning_model');
        $this->load->model('Invoice_model');
        $this->load->model('OrdersModel');
        $this->load->model('DryCleaning_model');
        $this->load->model('Billing_model');
        $this->load->model('Tailor_model');
    }

    public function index()
    {
        $this->load->view('index');
    }

    public function Sidebar()
    {
        $this->load->view('include/Sidebar');
    }

    public function Navbar()
    {
        $this->load->view('include/Navbar');
    }

    public function AddStock()
    {
        $this->load->view("Admin/AddStock");
    }

    public function AdminLogin()
    {
        $this->load->view("Admin/Login");
    }

    public function CommonLinks()
    {
        $this->load->view("CommonLinks");
    }
    public function DryCleaning_Forward()
    {
        $this->load->model('OrdersModel');
        $this->load->model('Vendor_model');

        $data['products'] = $this->OrdersModel->get_all_products_for_drycleaning();
        $data['vendors'] = $this->Vendor_model->get_all_vendors();
        // $this->load->view('AdminController/drycleaning_form', $data);
        $this->load->view('Admin/DryCleaning_Forward', $data);
    }



    // Save forward form to DB
    public function save_drycleaning_forward()
    {
        $this->load->model('DryCleaning_model');

        $data = [
            'vendor_name'     => $this->input->post('vendor_name'),
            'vendor_mobile'   => $this->input->post('vendor_mobile'),
            'product_name'    => $this->input->post('product_name'),
            'product_status'  => $this->input->post('product_status'),
            'forward_date'    => $this->input->post('forward_date'),
            'return_date'     => $this->input->post('return_date') ?: null,
            'status'          => 'In Cleaning', // default
            'expected_return' => $this->input->post('expected_return'),
            'cleaning_notes'  => $this->input->post('cleaning_notes'),
            'created_at'      => date('Y-m-d H:i:s'),
            'updated_at'      => date('Y-m-d H:i:s')
        ];

        if ($this->DryCleaning_model->insert($data)) {
            $this->session->set_flashdata('success', 'Dry cleaning forwarded successfully.');
        } else {
            $this->session->set_flashdata('error', 'Failed to forward dry cleaning.');
        }

        redirect('AdminController/DryCleaning_Forward');
    }

    public function saveSignature()
    {
        // Check if it's an AJAX request
        if (!$this->input->is_ajax_request()) {
            show_error('Direct access not allowed');
        }

        // Get POST data
        $invoice_id = $this->input->post('invoice_id');
        $signature_data = $this->input->post('signature_data');
        $document_hash = $this->input->post('document_hash');
        $customer_name = $this->input->post('customer_name');

        // Validate required fields
        if (empty($invoice_id) || empty($signature_data) || empty($document_hash)) {
            echo json_encode([
                'success' => false,
                'message' => 'Missing required fields'
            ]);
            return;
        }

        // Load model
        $this->load->model('Signature_model');

        // Prepare data
        $signature_data = [
            'invoice_id' => $invoice_id,
            'customer_name' => $customer_name,
            'signature_data' => $signature_data,
            'document_hash' => $document_hash,
            'signature_timestamp' => date('Y-m-d H:i:s')
        ];

        // Save to database
        $result = $this->Signature_model->saveSignature($signature_data);

        if ($result) {
            echo json_encode([
                'success' => true,
                'message' => 'Signature saved successfully'
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Failed to save signature'
            ]);
        }
    }


    // Status page
    public function DryCleaning_Status()
    {
        $this->load->model('DryCleaning_model');
        $data['drycleaning_data'] = $this->DryCleaning_model->get_all();
        $this->load->view('Admin/DryCleaning_Status', $data);
    }

    // AJAX update status
    public function update_status()
    {
        $id = $this->input->post('id');
        $status = $this->input->post('status');

        $this->load->model('DryCleaning_model');
        $updated = $this->DryCleaning_model->update_status($id, $status);

        echo json_encode(['success' => $updated]);
    }



    // AJAX delete
    public function delete_drycleaning()
    {
        $id = $this->input->post('id');

        $this->load->model('DryCleaning_model');
        $deleted = $this->DryCleaning_model->delete($id);

        echo json_encode(['success' => $deleted]);
    }

    // Add to stock (only if Returned)
    public function add_to_stock()
    {
        $productId = $this->input->post('product_id'); // send from your button
        $status = $this->input->post('status');

        if ($status !== 'Returned') {
            echo json_encode(['success' => false, 'message' => 'Status must be Returned']);
            return;
        }
        // Get product_id from drycleaning_status table
        $product_id = $this->input->post('product_id');

        // Increase stock in products table
        $this->db->set('stock', 'stock+1', FALSE);
        $this->db->where('id', $product_id);
        $this->db->update('products');


        // Get the current product
        $product = $this->Product_model->get_product_by_id($productId);

        if (!$product) {
            echo json_encode(['success' => false, 'message' => 'Product not found']);
            return;
        }

        // Increase stock
        $newStock = $product->stock + 1;
        $this->Product_model->update_product($productId, ['stock' => $newStock]);

        echo json_encode(['success' => true, 'new_stock' => $newStock]);
    }



    public function Orders()
    {

        $data['orders'] = $this->OrdersModel->get_orders();

        $this->load->view('Admin/Orders', $data);
    }
    public function Dashboard()
    {
        if (!$this->session->userdata('username')) {
            redirect('AdminController/Login');
        }

        // Load models first
        $this->load->model('Product_model');
        $this->load->model('Admin_Model');
        $this->load->model('Category_model');

        // Stock data
        $data['total_stock_quantity'] = $this->Product_model->get_total_stock_quantity();
        $data['total_stock_value'] = $this->Product_model->get_total_stock_value();

        // Deposits & Revenue
        $data['total_deposits'] = $this->Admin_Model->get_total_deposits();
        $data['total_revenue'] = $this->Admin_Model->get_total_revenue();

        // Category-wise sales
        $data['category_sales'] = $this->Admin_Model->get_category_wise_sales();
        // Analytics data
        $data['revenue_analytics'] = $this->Admin_Model->get_revenue_analytics();
        $data['category_sales'] = $this->Admin_Model->get_category_wise_sales();
        $data['payment_stats'] = $this->Admin_Model->get_payment_method_stats();
        $data['categories'] = $this->Category_model->get_all_categories();
        $data['recent_transactions'] = $this->Admin_Model->get_recent_transactions();

        $this->load->model('OrdersModel');

        // print_r($data['category_sales']);die;
        // Get sales data (product-wise sales)
        $data['sales'] = $this->OrdersModel->get_product_sales();
        // print_r($data['sales']);die;

        // Load dashboard view once
        $this->load->view('Admin/AdminDashboard', $data);
    }


    public function Login()
    {
        $data['message'] = $this->session->userdata('username') ? 'Login successful!' : null;
        $this->load->view('Admin/Login', $data);
    }

    public function AfterLogin()
    {
        $this->form_validation->set_rules('username', 'Username', 'required|trim');
        $this->form_validation->set_rules('password', 'Password', 'required|trim');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('AdminController/Login');
        } else {
            $username = $this->input->post('username', TRUE);
            $password = $this->input->post('password', TRUE);

            $user = $this->Login_Model->check_login($username, $password);

            if ($user) {
                $this->session->set_userdata([
                    'username' => $user->username,
                    'role'     => $user->role // Still store role from database if needed
                ]);

                $this->session->set_flashdata('success', 'Login successful!');
                redirect('AdminController/dashboard');
            } else {
                $this->session->set_flashdata('error', 'Invalid username or password.');
                redirect('AdminController/Login');
            }
        }
    }

    public function logout()
    {
        $this->session->sess_destroy();
        $this->session->set_flashdata('success', 'You have successfully logged out.');
        redirect('AdminController/Login');
    }

    public function AddStaff()
    {
        $this->load->view('Admin/StaffManagement');
    }

    public function StaffManagement()
    {
        $search = $this->input->get('search');
        $role   = $this->input->get('role');
        $data['staffs'] = $this->Admin_Model->get_all_staffs($search, $role);
        $this->load->view('Admin/StaffManagement', $data);
    }

    public function saveStaff()
    {
        $data = [
            'name'         => $this->input->post('name'),
            'email'        => $this->input->post('email'),
            'phone'        => $this->input->post('phone'),
            'address'      => $this->input->post('address'),
            'joining_date' => $this->input->post('joining_date'),
            'role'         => $this->input->post('role'),
            'username'     => $this->input->post('username'),
            'password'     => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
        ];
        $this->Admin_Model->insert_staff($data);
        redirect('AdminController/StaffManagement');
    }

    public function editStaff($id)
    {
        $staff = $this->Admin_Model->get_staff_by_id($id);
        if (!$staff) show_404();

        if ($_POST) {
            $username = $this->input->post('username');

            // Check for duplicate usernames
            $existing = $this->Admin_Model->get_by_username($username);
            if ($existing && $existing->id != $id) {
                $this->session->set_flashdata('error', 'Username already taken.');
                redirect('AdminController/editStaff/' . $id);
            }

            $data = [
                'name'         => $this->input->post('name'),
                'email'        => $this->input->post('email'),
                'phone'        => $this->input->post('phone'),
                'address'      => $this->input->post('address'),
                'joining_date' => $this->input->post('joining_date'),
                'role'         => $this->input->post('role'),
                'username'     => $username,
            ];

            if (!empty($this->input->post('password'))) {
                $data['password'] = password_hash($this->input->post('password'), PASSWORD_DEFAULT);
            }

            $this->Admin_Model->update_staff($id, $data);
            $this->session->set_flashdata('success', 'Staff updated successfully!');
        }
        redirect('AdminController/StaffManagement');
    }

    public function deleteStaff($id)
    {
        $this->Admin_Model->delete_staff($id);
        $this->session->set_flashdata('success', 'Staff deleted successfully!');
        redirect('AdminController/StaffManagement');
    }

    // (Removed duplicate pay_due_amount function. The correct one is at the end of the file.)
    //billing 
    public function Billing()
    {
        $this->load->model('Product_model');
        $this->load->model('Category_model');
        $data['categories'] = $this->Category_model->get_all_categories();
        $data['products'] = $this->Product_model->get_products_with_category();

        // Generate a temporary invoice number for display
        $date = date('Ymd');
        $rand = strtoupper(substr(md5(uniqid(rand(), true)), 0, 4));
        $data['temp_invoice_no'] = 'BILL-TEMP-' . $date . '-' . $rand;

        $this->load->view('Admin/BillSection', $data);
    }

    public function ProductInventory()
    {
        $this->load->model('Product_model');
        $this->load->model('Category_model');

        $data['products'] = $this->Product_model->get_all_products();
        $data['categories'] = $this->Category_model->get_all_categories();

        $this->load->view('Admin/product_inventory', $data);
    }

    public function AddCategory()
    {
        $this->load->view('Admin/add_category');
    }

    public function BillHistoryPage()
    {
        $this->load->view('Admin/BillHistory');
    }
    //concent form 

    public function MonthlyReport()
    {
        if (!$this->session->userdata('username')) {
            redirect('AdminController/Login');
        }

        // Get selected month/year or default to current
        $selected_month = $this->input->get('month') ?: date('m');
        $selected_year = $this->input->get('year') ?: date('Y');

        // Get report data
        $data['report'] = $this->Report_model->get_monthly_report($selected_year, $selected_month);


        $data['selected_month'] = $selected_month;
        $data['selected_year'] = $selected_year;
        $data['months'] = [
            '01' => 'January',
            '02' => 'February',
            '03' => 'March',
            '04' => 'April',
            '05' => 'May',
            '06' => 'June',
            '07' => 'July',
            '08' => 'August',
            '09' => 'September',
            '10' => 'October',
            '11' => 'November',
            '12' => 'December'
        ];
        $data['years'] = range(date('Y') - 5, date('Y'));

        $this->load->view('Admin/monthlyreport', $data);
    }
    public function DailyReport()
    {
        $this->load->model('Report_model');

        // Get today's date or selected date
        $date = $this->input->get('date') ? $this->input->get('date') : date('Y-m-d');

        // Get report data
        $data['report'] = $this->Report_model->get_daily_sales($date);
        $data['report_date'] = $date;

        // Load view
        $this->load->view('admin/DailyReport', $data);
    }

    public function Profile()
    {
        $this->load->view('Admin/Admin_Profile');
    }

    // Export to Excel without using library
    public function export_excel()
    {
        $customers = $this->CustomerModel->get_all_customers();

        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=customers_" . date('Ymd_His') . ".xls");

        echo "<table border='1'>";
        echo "<tr><th>ID</th><th>Name</th><th>Contact</th></tr>";
        foreach ($customers as $cust) {
            echo "<tr>";
            echo "<td>{$cust->id}</td>";
            echo "<td>{$cust->name}</td>";
            echo "<td>{$cust->contact}</td>";
            echo "</tr>";
        }
        echo "</table>";
    }



    // View-only PDF version (optional)

    public function change_password_handler()
    {
        if (!$this->session->userdata('username')) {
            $this->session->set_flashdata('error', 'Please log in first.');
            redirect('AdminController/Login');
        }

        $currentPassword = $this->input->post('currentPassword', TRUE);
        $newPassword     = $this->input->post('newPassword', TRUE);
        $confirmPassword = $this->input->post('confirmPassword', TRUE);

        $username = $this->session->userdata('username');

        $admin = $this->db->get_where('admin', ['username' => $username])->row();

        if (!$admin) {
            $this->session->set_flashdata('error', 'User not found.');
            redirect('AdminController/Profile');
        }

        if (!password_verify($currentPassword, $admin->password)) {
            $this->session->set_flashdata('error', 'Current password is incorrect.');
            redirect('AdminController/Profile');
        }

        if ($newPassword !== $confirmPassword) {
            $this->session->set_flashdata('error', 'New passwords do not match.');
            redirect('AdminController/Profile');
        }

        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        $this->db->where('username', $username);
        $this->db->update('admin', ['password' => $hashedPassword]);

        $this->session->set_flashdata('success', 'Password updated successfully.');
        redirect('AdminController/Profile');
    }

    public function hash_existing_passwords()
    {
        $this->load->database();

        $admins = $this->db->get('admin')->result();

        foreach ($admins as $admin) {
            // Skip if already hashed (optional check, for example length > 60 chars)
            if (strlen($admin->password) < 60) {
                $hashed = password_hash($admin->password, PASSWORD_DEFAULT);
                $this->db->where('id', $admin->id)->update('admin', ['password' => $hashed]);
            }
        }

        echo "Password hashing completed for existing admin users.";
    }


    /* -------- BILLING FORM (CREATE) ---------- */
    public function billing_dashboard()
    {
        // Get categories and products for dependent selects
        $data['categories'] = $this->Billing_model->get_categories();           // id, name
        $data['products']   = $this->Billing_model->get_products_with_cat();    // id, name, category_id, price, status
        $this->load->view('BillingDashboard', $data);
    }



    /* -------- BILLING HISTORY (LIST) ---------- */
    public function BillHistory()
    {
        $from = $this->input->get('from');
        $to   = $this->input->get('to');

        $data['invoices'] = $this->Billing_model->get_invoices($from, $to);

        // Fetch items for each invoice
        foreach ($data['invoices'] as &$inv) {
            $inv['items'] = $this->db->where('invoice_id', $inv['id'])->get('invoice_items')->result_array();
        }

        $this->load->view('Admin/BillHistory', $data);
    }

    /* --------- API for dependent dropdown (optional AJAX) ---------- */
    public function get_products_by_category($category_id)
    {
        $products = $this->Billing_model->get_products_by_category((int)$category_id);
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($products));
    }

    /* -------- VIEW / DELETE (optional) -------- */
    public function view_invoice($id)
    {
        if (!$this->input->is_ajax_request()) show_404();
        $this->load->model('Billing_model');
        $invoice = $this->Billing_model->get_invoice_by_id($id);
        if (!$invoice) {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['success' => false, 'message' => 'Invoice not found']));
            return;
        }
        // Ensure all item fields are present and properly typed
        if (isset($invoice['items']) && is_array($invoice['items'])) {
            foreach ($invoice['items'] as &$item) {
                $item['category'] = isset($item['category']) ? $item['category'] : '';
                $item['item_name'] = isset($item['item_name']) ? $item['item_name'] : '';
                $item['price'] = isset($item['price']) ? (float)$item['price'] : 0.0;
                $item['quantity'] = isset($item['quantity']) ? (int)$item['quantity'] : 0;
                $item['total'] = isset($item['total']) ? (float)$item['total'] : 0.0;
            }
        }
        $invoice['success'] = true;
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($invoice));
    }

    public function delete_invoice($id)
    {
        $this->Billing_model->delete_invoice((int)$id);
        $this->session->set_flashdata('success', 'Invoice deleted.');
        // Redirect to BillHistory (case-sensitive, matches route)
        redirect('AdminController/BillHistory');
    }

    // AJAX endpoint for products by category
    public function get_products()
    {
        $category_id = $this->input->post('category_id');
        $products = $this->Product_model->get_products_by_category($category_id);
        echo json_encode($products);
    }

    /**
     * AJAX endpoint to pay/update due amount for an invoice
     * Expects: invoice_id, pay_amount (amount to pay towards due)
     * Returns: JSON (success, new paid/due values, message)
     */
    public function pay_due_amount()
    {
        if (!$this->input->is_ajax_request()) show_404();
        $invoice_id = $this->input->post('invoice_id');
        $pay_amount = (float)$this->input->post('pay_amount');
        $pay_mode = $this->input->post('pay_due_payment_mode');
        $this->load->model('Billing_model');
        $invoice = $this->Billing_model->get_invoice_by_id($invoice_id);
        if (!$invoice) {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['success' => false, 'message' => 'Invoice not found']));
            return;
        }
        // Only allow payment if there is a due amount
        $current_due = (float)$invoice['due_amount'];
        $current_paid = (float)$invoice['paid_amount'];
        if ($pay_amount <= 0 || $pay_amount > $current_due) {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['success' => false, 'message' => 'Invalid amount']));
            return;
        }
        // Calculate new paid and due amounts
        $new_paid = $current_paid + $pay_amount;
        $new_due = $current_due - $pay_amount;
        // Update invoice
        $update = $this->Billing_model->update_invoice($invoice_id, [
            'paid_amount' => $new_paid,
            'due_amount' => $new_due,
            'payment_mode' => $pay_mode
        ]);
        // Log payment
        $log = $this->Billing_model->log_due_payment($invoice_id, $pay_amount);
        if ($update && $log) {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode([
                    'success' => true,
                    'message' => 'Due payment updated successfully',
                    'paid_amount' => $new_paid,
                    'due_amount' => $new_due
                ]));
        } else {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['success' => false, 'message' => 'Failed to update due payment.']));
        }
    }
    // update payment
    public function update_payment()
    {
        $id          = $this->input->post('invoice_id'); // numeric id
        $paidAmount  = (float) $this->input->post('paid_amount');
        $dueAmount   = (float) $this->input->post('due_amount');
        $paymentMode = $this->input->post('payment_mode');

        $invoice = $this->db->get_where('invoices', ['id' => $id])->row();

        if ($invoice) {
            $this->db->where('id', $id);
            $this->db->update('invoices', [
                'paid_amount'  => $paidAmount,
                'due_amount'   => $dueAmount,
                'payment_mode' => $paymentMode
            ]);

            echo json_encode([
                'status'       => 'success',
                'id'           => $id,
                'paid_amount'  => $paidAmount,
                'due_amount'   => $dueAmount,
                'payment_mode' => $paymentMode
            ]);
        } else {
            echo json_encode(['status' => 'error', 'msg' => 'Invoice not found', 'id' => $id]);
        }
    }
    public function update_due_manual()
    {
        $id          = $this->input->post('invoice_id');
        $paidAmount  = (float)$this->input->post('paid_amount');
        $dueAmount   = (float)$this->input->post('due_amount');
        $paymentMode = $this->input->post('payment_mode');

        $this->load->model('Billing_model');
        $updated = $this->Billing_model->update_invoice($id, [
            'paid_amount'  => $paidAmount,
            'due_amount'   => $dueAmount,
            'payment_mode' => $paymentMode
        ]);

        if ($updated) {
            echo json_encode(['success' => true, 'message' => 'Payment updated successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to update']);
        }
    }

    public function updateOrderStatus()
    {
        $invoice_id = $this->input->post('invoice_id');
        $item_name  = $this->input->post('item_name');
        $status     = $this->input->post('status');

        log_message('debug', 'UpdateOrderStatus: invoice_id=' . $invoice_id . ' item_name=' . $item_name . ' status=' . $status);

        if ($invoice_id && $item_name && $status) {
            $this->load->model('OrdersModel');
            $updated = $this->OrdersModel->update_status($invoice_id, $item_name, $status);

            echo json_encode(['success' => $updated, 'msg' => $updated ? 'Updated' : 'No rows affected']);
        } else {
            echo json_encode(['success' => false, 'msg' => 'Missing params']);
        }
    }

    public function productSales()
    {
        $this->load->model('OrdersModel');
        $data['sales'] = $this->OrdersModel->get_product_sales();
        $this->load->view('product_sales', $data);
    }
    public function save_invoice()
    {
        $this->load->database();
        $this->load->helper('url');
        $this->load->model('Product_model');

        // Save main invoice
        $invoiceData = [
            'invoice_no'      => $this->input->post('invoiceNo'),
            'customer_name'   => $this->input->post('customerName'),
            'customer_mobile' => $this->input->post('customerMobile'),
            'invoice_date'    => $this->input->post('date'),
            'return_date'     => $this->input->post('returnDate'),
            'deposit_amount'  => $this->input->post('depositAmount') ?: 0,
            'discount_amount' => $this->input->post('discountAmount') ?: 0,
            'total_amount'    => $this->input->post('totalAmount') ?: 0,
            'total_payable'   => $this->input->post('totalPayable') ?: 0,
            'paid_amount'     => $this->input->post('paidAmount') ?: 0,
            'due_amount'      => $this->input->post('dueAmount') ?: 0,
            'payment_mode'    => $this->input->post('paymentMode'),
        ];

        // Start transaction for data integrity
        $this->db->trans_start();

        if ($this->db->insert('invoices', $invoiceData)) {
            $invoice_id = $this->db->insert_id();

            // Get items from POST
            $items_json = $this->input->post('items');
            $items = json_decode($items_json, true);

            if (!empty($items) && is_array($items)) {
                foreach ($items as $item) {
                    // Check if the item has the required fields
                    if (!isset($item['item_name']) || !isset($item['quantity'])) {
                        continue;
                    }
                    // Fetch category name from categories table using category ID
                    $category_name = '';
                    if (!empty($item['category'])) {
                        $this->db->select('name');
                        $this->db->where('id', $item['category']);
                        $category_query = $this->db->get('categories');
                        if ($category_query->num_rows() > 0) {
                            $category_name = $category_query->row()->name;
                        }
                    }

                    $invoice_item_data = [
                        'invoice_id' => $invoice_id,
                        'item_name'  => $item['item_name'],
                        'category'   => $item['category'] ?? '',
                        'category_name'  => $category_name, // Now populated
                        'price'      => $item['price'] ?? 0,
                        'quantity'   => $item['quantity'],
                        'total'      => $item['total'] ?? 0,
                        'status'     => 'Rented',
                        'times_rented' => 1
                    ];

                    // Insert into invoice_items
                    $this->db->insert('invoice_items', $invoice_item_data);

                    // Update stock using item_name
                    $this->Product_model->update_stock_after_sale(
                        $item['item_name'],
                        $item['quantity']
                    );
                }
            }

            // Complete transaction
            $this->db->trans_complete();

            if ($this->db->trans_status() === FALSE) {
                // Transaction failed
                $this->db->trans_rollback();
                $this->session->set_flashdata('error', 'Failed to save invoice and update inventory');
                redirect('AdminController/invoice_form');
            } else {
                // Transaction succeeded - redirect to consent form
                redirect('AdminController/consent_form/' . $invoiceData['invoice_no']);
            }
        } else {
            $this->session->set_flashdata('error', 'Failed to save invoice');
            redirect('AdminController/invoice_form');

            // After saving invoice items, update stock
            foreach ($this->input->post('items') as $item) {
                $this->db->set('stock', 'stock - ' . (int)$item['quantity'], FALSE);
                $this->db->where('id', $item['product_id']);
                $this->db->update('products');

                if ($this->db->trans_status() === FALSE) {
                    // Transaction failed
                    $this->db->trans_rollback();
                    $this->session->set_flashdata('error', 'Failed to save invoice and update inventory');
                    redirect('AdminController/invoice_form');
                } else {
                    // Transaction succeeded - redirect to consent form with invoice number
                    redirect('AdminController/consent/' . $invoiceData['invoice_no']);
                }
            }
        }
    }
    public function return_item($invoice_item_id)
    {
        $item = $this->db->get_where('invoice_items', ['id' => $invoice_item_id])->row();

        if (!$item) return false;

        // Find product by name instead of ID
        $product = $this->db->get_where('products', ['name' => $item->item_name])->row();

        if ($product && $item->status !== 'Returned') {
            $this->db->set('stock', 'stock + ' . (int)$item->quantity, FALSE);
            $this->db->where('id', $product->id);
            $this->db->update('products');

            $this->db->where('id', $invoice_item_id);
            $this->db->update('invoice_items', ['status' => 'Returned']);

            return true;
        }

        return false;
    }
    public function consent_form($invoice_no)
    {
        // Fetch invoice data
        $this->load->database();
        $invoice = $this->db->get_where('invoices', ['invoice_no' => $invoice_no])->row_array();

        // Check if invoice exists
        if (!$invoice) {
            show_error('Invoice not found', 404);
        }

        // Fetch invoice items
        $invoice_id = $invoice['id'];
        $items = $this->db->get_where('invoice_items', ['invoice_id' => $invoice_id])->result_array();

        // Pass data to view
        $data['invoice'] = $invoice;
        $data['items'] = $items;

        $this->load->view('admin/consent', $data); // Load your consent view
    }

    public function increaseStock()
    {
        $drycleaning_id = $this->input->post('id');

        // First, get the dry cleaning record to find the product name
        $this->db->where('id', $drycleaning_id);
        $query = $this->db->get('drycleaning_status');
        $drycleaning_item = $query->row();

        if (!$drycleaning_item) {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(array('success' => false, 'message' => 'Dry cleaning record not found')));
            return;
        }

        // Find the product by name
        $this->db->where('name', $drycleaning_item->product_name);
        $query = $this->db->get('products');
        $product = $query->row();

        if ($product) {
            // Increment the stock by 1
            $new_stock = $product->stock + 1;

            // Update the database
            $this->db->where('id', $product->id);
            $this->db->update('products', array('stock' => $new_stock));

            // Also delete the dry cleaning record
            $this->db->where('id', $drycleaning_id);
            $this->db->delete('drycleaning_status');

            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(array('success' => true, 'new_stock' => $new_stock)));
        } else {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(array('success' => false, 'message' => 'Product not found in inventory')));
        }
    }
    public function save_drycleaning()
    {
        $this->load->model('DryCleaning_model');

        $data = [
            'vendor_name'     => $this->input->post('vendor_name'),
            'vendor_mobile'   => $this->input->post('vendor_mobile'),
            'product_name'    => $this->input->post('product_name'),
            'product_status'  => $this->input->post('product_status'),
            'forward_date'    => $this->input->post('forward_date'),
            'return_date'     => $this->input->post('return_date') ?: null,
            'status'          => 'Forwarded', // default
            // 'expected_return' => $this->input->post('expected_return') ?: null,
            'cleaning_notes'  => $this->input->post('cleaning_notes'),
            'created_at'      => date('Y-m-d H:i:s'),
            'updated_at'      => date('Y-m-d H:i:s')
        ];

        if ($this->DryCleaning_model->insert($data)) {
            $this->session->set_flashdata('success', 'Record added successfully.');
        } else {
            $this->session->set_flashdata('error', 'Failed to add record.');
        }

        redirect('AdminController/DryCleaning_Status');
    }
    public function Vendors()
    {
        $this->load->model('Vendor_model');
        $data['vendors'] = $this->Vendor_model->get_all_vendors();


        // OR if it's in application/views/Admin/vendors.php
        $this->load->view('Admin/Vendors', $data);
    }
    // Tailor Management
    public function tailors()
    {
        $this->load->model('Tailor_model');
        $data['tailors'] = $this->Tailor_model->get_all_tailors();
        $this->load->view('Admin/Tailors', $data);
    }
}
