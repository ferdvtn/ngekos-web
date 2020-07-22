<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tersewa extends MY_Controller
{
    public $data = [];

    public function __construct()
    {
        parent::__construct();
        $this->load->model(['tersewa_model', 'status_pengajuan_model', 'pengajuan_model']);
        $this->load->library(['form_validation']);
        // $this->load->helper('form');
        // $this->load->library(['lib_kos', 'lib_pengajuan', 'check_auth', 'form_validation']);
    }

    public function approval()
    {
		$input = $this->input->post();
        $this->form_validation->set_rules('id', '', 'required');
        $this->form_validation->set_rules('id_pemilik', '', 'required');
        $this->form_validation->set_rules('id_penyewa', '', 'required');
        $this->form_validation->set_rules('id_kos', '', 'required');
        $this->form_validation->set_rules('penghuni', '', 'required|numeric');
        if ($this->form_validation->run() != false) {
			$this->pengajuan_model->delete('id_pengajuan', $input['id']);
            $sp_input = [
                'id_pengajuan' => $input['id'],
                'id_user_pemilik' => $input['id_pemilik'],
                'id_user_pengaju' => $input['id_penyewa'],
                'id_kos' => $input['id_kos'],
                'status_pengajuan' => $input['status'],
                'keterangan' => $input['keterangan']
			];
            $this->status_pengajuan_model->insert($sp_input);
            if ($input['status'] == 1) {
                $pn_input = [
                    'id_kostersewa' => guid(),
                    'id_user' => $input['id_penyewa'],
                    'id_kos' => $input['id_kos'],
                    'penghuni' => $input['penghuni'],
                    'keterangan' => $input['keterangan']
                ];
                $this->tersewa_model->insert($pn_input);
            }
            $this->flashMessage('SUCCESS', 'Tanggapan anda telah tersampaikan ke pengaju!');
            redirect($_SERVER['HTTP_REFERER']);
        } else {
            $this->flashMessage('ERROR', 'Kesalahan dalam input data!');
            redirect(base_url('/'));
        }
    }
}