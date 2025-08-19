<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login_Model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    // Check login credentials
    public function check_login($username, $password)
    {
        $this->db->where('username', $username);
        $query = $this->db->get('admin');
        $user = $query->row();

        if ($user && password_verify($password, $user->password)) {
            return $user;
        }
        return false;
    }
}
