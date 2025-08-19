<?php
class Category_model extends CI_Model {

    public function get_all() {
        return $this->db->get('categories')->result();
    }

    public function insert_category($data) {
        return $this->db->insert('categories', $data);
    }
    public function get_all_categories() {
        return $this->db->order_by('name', 'ASC')->get('categories')->result_array();
    }

}
