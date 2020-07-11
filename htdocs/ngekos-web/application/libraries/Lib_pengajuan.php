<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lib_pengajuan {

    protected $CI;

    public function __construct()
    {
        $this->CI =& get_instance();
        $this->CI->load->model(['user_model', 'pengajuan_model', 'status_pengajuan_model']);
    }

    /**
     * cek pengajuan is exists
     */
    public function submissionCheckIsExists($id_kos, $id_pengaju)
    {
        $detail = [
            'id_pengaju' => $id_pengaju,
            'id_kos' => $id_kos
        ];
        $this->CI->db->select('*');
        $this->CI->db->from('pengajuan');
        $this->CI->db->where($detail);
        $result = $this->CI->db->get();
        if ($result->num_rows() > 0) return true;
        else return false;
    }

    public function getByUser($id)
    {
        $results = $this->CI->pengajuan_model->getByUser($id);
		$status_pengajuan = $this->CI->status_pengajuan_model->get();

        if (!empty($results)) {
            foreach ($results as $result) {
                if ($result->id_pemilik == $this->CI->session->userdata('id')) {
                    foreach ($status_pengajuan as $sp) {
                        if ($result->id == $sp->id_pengajuan) {
                            if ($sp->status == 1) {
                                $result->status = 'disetujui';
                            } else if ($sp->status == 0) {
                                $result->status = 'ditolak';
                            }
                        }
                    }
                }
            }
        }
        return $results;
    }
}