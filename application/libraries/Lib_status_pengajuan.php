<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lib_status_pengajuan {

    protected $CI;

    public function __construct()
    {
        $this->CI =& get_instance();
        $this->CI->load->model(['status_pengajuan_model']);
    }

    public function getByUser($id)
    {
        $results = $this->CI->status_pengajuan_model->getByUser($id);
        return $results;
    }
}