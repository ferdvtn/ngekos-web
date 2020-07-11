<?php

class status_pengajuan_model extends MY_Model {

    public function __construct()
    {
        $this->controller_name = __CLASS__;
        $this->table_name = 'status_pengajuan';
        parent::__construct();
    }

    public function getByUser($id)
    {
        $this->db->select('sp.*, user.nama as pemilik, user.no_handphone as no_pemilik, kos.judul as nama_kos');
        $this->db->from('status_pengajuan as sp');
        $this->db->join('user', 'user.id = sp.id_pemilik');
        $this->db->join('kos', 'kos.id = sp.id_kos');
        $this->db->where('sp.id_pengaju', $id);
        $this->db->order_by('sp.created_at', 'DESC');
        $data = $this->db->get();
        if ($data->num_rows() > 0) {
            return $data->result();
        } else return null;
    }

    public function insert($rows)
    {
        parent::insert($rows);
    }
}