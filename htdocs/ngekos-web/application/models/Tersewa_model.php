<?php

class Tersewa_model extends MY_Model{

    public function __construct()
    {
        $this->controller_name = __CLASS__;
        $this->table_name = 'kostersewa';
        parent::__construct();
    }

    public function getTotalTersewa($idKos)
    {
        $this->db->select('*');
        $this->db->from('kostersewa');
        $this->db->where('id_kos', $idKos);
        $results = $this->db->get();
        return $results->num_rows();
    }

    public function insert($rows)
    {
        parent::insert($rows);
    }
}