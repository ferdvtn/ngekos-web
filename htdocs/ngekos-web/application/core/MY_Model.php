<?php

class MY_Model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }

    public function get($id = null)
    {
        if ($id==null) {
            $this->db->select('*');
            $this->db->from($this->table_name);
            $data = $this->db->get()->result();
            return $data;
        } else {
            $this->db->select('*');
            $this->db->from($this->table_name);
            $data = $this->db->where('id', $id)->first_row();
            return $data;
        }
    }

    protected function insert($rows)
    {
		if (array_key_exists('submit', $rows)) { unset($rows['submit']); }
		if (!isset($rows['id'])) { $rows['id'] = guid(); }

		$rows['created_at'] = date("Y-m-d H:i:s");
		$rows['updated_at'] = date("Y-m-d H:i:s");


		$this->db->insert($this->table_name, $rows);

		return $rows['id'];
	}

    protected function update($rows)
    {
        if (array_key_exists('submit', $rows)) unset($rows['submit']);
		$this->db->where('id', $rows['id']);
		$id = $rows['id'];
		if (array_key_exists('id', $rows)) unset($rows['id']);
		$rows['updated_at'] = date("Y-m-d H:i:s");

		$this->db->update($this->table_name, $rows);

		return $id;

    }

    protected function delete($id)
    {
        $this->db->where('id', $id);
        $this->db->delete($this->table_name);
    }
}