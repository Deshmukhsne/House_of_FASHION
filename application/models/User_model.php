<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User_model extends CI_Model
{

    // Get user details by ID
    public function get_user_by_id($id)
    {
        $query = $this->db->get_where('users', ['id' => $id]);
        return $query->row();  // returns object
    }

    // Update user's password
    public function update_password($id, $hashedPassword)
    {
        return $this->db->update('users', ['password' => $hashedPassword], ['id' => $id]);
    }

    // Authenticate login
    public function login($username, $password)
    {
        $query = $this->db->get_where('users', ['username' => $username]);
        $user = $query->row();

        if ($user && password_verify($password, $user->password)) {
            return $user;
        }

        return false;
    }

      public function get_all_staff()
    {
        $this->db->select('id, name');
        $this->db->from('users');
        // Remove or keep this if you only want staff:
        // $this->db->where('role', 'staff');
        $query = $this->db->get();
        return $query->result(); // returns an array of objects
    }

}
