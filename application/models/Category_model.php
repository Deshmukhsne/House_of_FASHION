<?php
class Category_model extends CI_Model
{

    public function get_all()
    {
        return $this->db->get('categories')->result();
    }

    public function insert_category($data)
    {
        return $this->db->insert('categories', $data);
    }
    /*************  ✨ Windsurf Command ⭐  *************/
    /**
     * Retrieves all categories from the database, sorted by name in ascending order.
     *
     * @return array An array of category objects, each containing 'id', 'name', and 'description'.
     */
    /*******  11a5a926-e0af-40d0-bba6-3a783a33063c  *******/
    public function get_all_categories()
    {
        return $this->db->order_by('name', 'ASC')->get('categories')->result_array();
    }
}
