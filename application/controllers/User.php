<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends MY_Controller {
    public $data = [];

    public function __construct()
    {
        parent::__construct();
        $this->load->library(['form_validation', 'check_auth', 'lib_kos', 'lib_user']);
        $this->load->model(['user_model', 'kos_model', 'status_pengajuan_model', 'pengajuan_model']);
    }

    public function edit()
    {
        $this->check_auth->is_logged_in();
        $idUser = $this->session->userdata('id');
        $this->data['user'] = $this->user_model->get_by_id($idUser);
        $is_unique = ($this->input->post('email') != $this->data['user']['email']) ? '|is_unique[user.email]' : '' ;
        $this->form_validation->set_rules('nama', 'nama', 'trim|required|min_length[3]|max_length[50]');
        $this->form_validation->set_rules('email', 'email', 'trim|required|valid_email|max_length[50]' . $is_unique);
        $this->form_validation->set_rules('no_handphone', 'nomor handphone', 'trim|required|max_length[15]|numeric');
        $this->form_validation->set_rules('alamat', 'trim|alamat ');
        if ($this->form_validation->run() == true){
            // $this->user_model->update($this->input->post());
            $newData = [
                'nama' => $this->input->post('nama'),
                'email' => $this->input->post('email'),
                'no_handphone' => $this->input->post('no_handphone'),
                'alamat' => $this->input->post('alamat'),
            ];
            $this->db->where('id', $idUser);
            $this->db->update('user', $newData);
            $this->flashMessage('SUCCESS', 'Berhasil memperbarui profile');
            redirect('profile');
        } else {
            $this->data['title'] = $this->data['user']['nama'] . ' | Edit Profile';
            $this->data['kos'] = $this->kos_model->get($idUser);
            $this->data['sisa'] = $this->lib_kos->getTersisa();
            $this->data['tersewa'] = $this->lib_kos->getTersewa();
            $this->data['totalKamarKos'] = $this->lib_kos->getKos();
            $this->flashMessage('ERROR', 'Cek kembali data yang anda masukan!');
            $load_view = ['templates/head-profile', 'profile-edit'];
            parent::frontDisplay($load_view);
        }
	}

	/**
	 * change profile picture
	 *
	 * @return void
	 */
	public function cp()
	{
		$id = $this->input->post('id');
		$file = $_FILES;
		$upload = $this->lib_user->change_picture($file, $id);
		if ($upload) {
			$this->flashMessage('SUCCESS', 'Foto profile telah diganti');
			redirect(go_back());
		}
	}

	/**
	 * status
	 * menampilkan semua status
	 * @return page
	 */
	public function s()
	{
		$this->check_auth->is_logged_in();
		$user_id = $this->session->userdata('id');
		$this->data['user'] = $this->user_model->get_by_id($user_id);
		$this->data['status'] = $this->status_pengajuan_model->getByUser($user_id);
		$this->data['title'] = 'Status';
		$this->data['kos_terbaru'] = $this->db->select('kos.*, user.nama as pemilik, user.no_handphone, user.alamat as alamat_pemilik')
									->from('kos')->order_by('created_at', 'DESC')->limit(4)
									->join('user', 'user.id = kos.id_pemilik')
									->get()->result();
		parent::frontDisplay('list-status');
	}

	/**
	 * notifications
	 * menampilkan semua notification
	 *
	 * @return page
	 */
	public function n()
	{
		$this->check_auth->is_logged_in();
		$user_id = $this->session->userdata('id');
		$this->data['user'] = $this->user_model->get_by_id($user_id);
		$this->data['title'] = 'Notifications';
		$this->data['kos_terbaru'] = $this->db->select('kos.*, user.nama as pemilik, user.no_handphone, user.alamat as alamat_pemilik')
									->from('kos')->order_by('created_at', 'DESC')->limit(4)
									->join('user', 'user.id = kos.id_pemilik')
									->get()->result();
		parent::frontDisplay('list-notification');
	}
}