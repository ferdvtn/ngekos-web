<?php

class Pengajuan_model extends MY_Model{

    public function __construct()
    {
        $this->controller_name = __CLASS__;
        $this->table_name = 'pengajuan';
        parent::__construct();
    }

    /**
     * Select All atau by id_pengajuan
     */
    public function get($id = null)
    {
        if ($id==null) {
            $this->db->select('*');
            $this->db->from('pengajuan');
            $data = $this->db->get()->result();
            return $data;
        } else {
            $this->db->select('*');
            $this->db->from('pengajuan');
            $data = $this->db->where('id_pengajuan', $id)->first_row();
            return $data;
        }
    }

    public function getByUser($id)
    {
        $this->db->select('pengajuan.*, user.nama as pengaju, user.no_handphone as no_pengaju, kos.judul as nama_kos');
        $this->db->from('pengajuan');
        $this->db->join('user', 'user.id = pengajuan.id_pengaju');
        $this->db->join('kos', 'kos.id = pengajuan.id_kos');
        $this->db->where('pengajuan.id_pemilik', $id);
        $this->db->or_where('pengajuan.id_pengaju', $id);
        $this->db->order_by('pengajuan.created_at', 'DESC');
        $data = $this->db->get();
        if ($data->num_rows() > 0) {
            return $data->result();
        } else return null;
    }

    public function insert($rows)
    {
        parent::insert($rows);
    }

    public function update($rows)
    {
        parent::update($rows);
    }

    public function delete($id)
    {
        parent::delete($id);
    }

    public function is_exists($idrows)
    {
        // echo '<pre>';
        //     print_r($idrows);
        // echo '</pre>';
        // die();
    }
}