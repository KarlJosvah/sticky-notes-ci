<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sticky_notes_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->_check_table();
    }

    private function _check_table() {
        if (!$this->db->table_exists('sticky_notes')) {
            $this->load->dbforge();
            $this->dbforge->add_field(array(
                'id' => array('type' => 'INTEGER', 'primary_key' => TRUE, 'auto_increment' => TRUE),
                'title' => array('type' => 'VARCHAR', 'constraint' => '255'),
                'content' => array('type' => 'TEXT'),
                'created_at' => array('type' => 'DATETIME', 'default' => 'CURRENT_TIMESTAMP')
            ));
            $this->dbforge->create_table('sticky_notes');
        }
    }

    public function get_all_notes() {
        $query = $this->db->order_by('created_at', 'DESC')->get('sticky_notes');
        return $query->result_array();
    }

    public function get_note($id) {
        $query = $this->db->get_where('sticky_notes', array('id' => $id));
        return $query->row_array();
    }

    public function create_note($data) {
        return $this->db->insert('sticky_notes', $data);
    }

    public function update_note($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('sticky_notes', $data);
    }

    public function delete_note($id) {
        $this->db->where('id', $id);
        return $this->db->delete('sticky_notes');
    }
}
