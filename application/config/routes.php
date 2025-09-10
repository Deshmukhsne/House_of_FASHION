<?php
defined('BASEPATH') or exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/userguide3/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'index';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
$route['dashboard'] = 'AdminController/dashboard';
$route['customers'] = 'AdminController/customers';

$route['customers/add'] = 'AdminController/add_customer';
$route['customers/update'] = 'AdminController/update_customer';
$route['customers/delete/(:num)'] = 'AdminController/delete_customer/$1';
$route['customers/get/(:num)'] = 'AdminController/get_customer/$1';
$route['customers/export_excel'] = 'AdminController/export_excel';
$route['customers/export_pdf'] = 'AdminController/export_pdf';
$route['customers/export_pdf'] = 'AdminController/export_pdf_view';
$route['AdminController/view_invoice/(:num)'] = 'AdminController/view_invoice/$1';
$route['AdminController/pay_due_amount'] = 'AdminController/pay_due_amount';
$route['updateOrderStatus'] = 'AdminController/updateOrderStatus';
$route['Login'] = 'index.php/AdminController/dashboard';
// Dashboard
$route['dashboard'] = 'AdminController/Dashboard';

// Stock
$route['stock'] = 'AdminController/ProductInventory';

// Billing
$route['billing'] = 'AdminController/Billing';
$route['billing-history'] = 'AdminController/BillHistory';

// Orders
$route['orders'] = 'AdminController/Orders';

// Vendor Management
$route['vendors'] = 'AdminController/Vendors';
$route['tailors'] = 'AdminController/Tailors';
$route['dry-status'] = 'AdminController/DryCleaning_Status';
$route['tailor-status'] = 'AdminController/tailor_history';

// Reports
$route['daily-report'] = 'AdminController/DailyReport';
$route['monthly-report'] = 'AdminController/MonthlyReport';

// Staff Management
$route['staff'] = 'AdminController/StaffManagement';

// Profile
$route['profile'] = 'AdminController/Profile';

// Login / Logout
$route['login'] = 'AdminController/login';
