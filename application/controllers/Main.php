<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends MY_Controller {

	public $data = [];

    public function __construct()
    {
        parent::__construct();
        $this->load->library(['check_auth', 'form_validation', 'lib_kos']);
        $this->load->model(['user_model', 'kos_model']);
    }

    public function index()
    {
        // $this->check_auth->is_logged_in();
        $idUser = $this->session->userdata('id');
        $this->data['kos'] = $this->kos_model->get('', 12);
        $this->data['user'] = $this->user_model->get_by_id($idUser);
		$this->data['title'] = "Home | Ngekos";
        parent::frontDisplay('front-index');
	}

	public function profile()
    {
        $this->check_auth->is_logged_in();
        $idUser = $this->session->userdata('id');
        $this->data['user'] = $this->user_model->get_by_id($idUser);
        $this->data['kos'] = $this->kos_model->get($idUser);
        $this->data['sisa'] = $this->lib_kos->getTersisa();
        $this->data['tersewa'] = $this->lib_kos->getTersewa();
        $this->data['totalKamarKos'] = $this->lib_kos->getKos();
        $this->data['title'] = $this->data['user']['nama'] . ' | Profile';
        $load_view = ['templates/head-profile', 'profile'];
        parent::frontDisplay($load_view);
	}

	public function penyewa()
	{
		$this->check_auth->is_logged_in();
        $idUser = $this->session->userdata('id');
        $this->data['user'] = $this->user_model->get_by_id($idUser);
        $this->data['kos'] = $this->kos_model->getPenyewa($idUser);
        $this->data['sisa'] = $this->lib_kos->getTersisa();
        $this->data['tersewa'] = $this->lib_kos->getTersewa();
        $this->data['totalKamarKos'] = $this->lib_kos->getKos();
        $this->data['title'] = $this->data['user']['nama'] . ' | Profile';
		$load_view = ['templates/head-profile', 'penyewa'];
        parent::frontDisplay($load_view);
	}

    public function edit()
    {
        $this->check_auth->is_logged_in();
        $idUser = $this->session->userdata('id');
        $this->data['user'] = $this->user_model->get_by_id($idUser);
        $this->data['kos'] = $this->kos_model->get($idUser);
        $this->data['sisa'] = $this->lib_kos->getTersisa();
        $this->data['tersewa'] = $this->lib_kos->getTersewa();
        $this->data['totalKamarKos'] = $this->lib_kos->getKos();
        $this->data['title'] = $this->data['user']['nama'] . ' | Edit Profile';
        $load_view = ['templates/head-profile', 'profile-edit'];
        parent::frontDisplay($load_view);
	}

	public function delete_penyewa()
	{
		$input = $this->input->get();
		$this->db->select('*');
		$this->db->from('tersewa');
		$this->db->where('id', $input['id']);
		$get = $this->db->get();
		if ($get->num_rows() > 0) {
			$result = $get->first_row();

			//delete from table status_pengajuan
			$this->db->from('status_pengajuan');
			$this->db->where('id_pengaju', $result->id_penyewa);
			$this->db->where('id_kos', $result->id_kos);
			$get_sp = $this->db->get();
			if ($get_sp->num_rows() > 0) {
				$get_sp = $get_sp->first_row();
				$this->db->where('id', $get_sp->id);
				$this->db->delete('status_pengajuan');
			}

			// delete from table penyewa
			$this->db->where('id', $result->id);
			$this->db->delete('tersewa');

			$this->flashMessage('SUCCESS', '<b>Berhasil!</b> Data telah dihapus!');
            redirect('profile/penyewa');
		} else {
			$this->flashMessage('ERROR', '<b>Maaf!</b> Halaman tidak ditemukan!');
            redirect('profile/penyewa');
		}
	}

    public function tambahKos()
    {
        $this->check_auth->is_logged_in();
        $idUser = $this->session->userdata('id');
        $this->form_validation->set_rules('judul', 'Title', 'required|min_length[5]|max_length[50]');
        $this->form_validation->set_rules('alamat', 'Alamat', 'required|min_length[10]');
        $this->form_validation->set_rules('luas', 'Luas', 'required|max_length[5]|numeric');
        $this->form_validation->set_rules('harga', 'Harga', 'required|numeric');
        $this->form_validation->set_rules('pintu', 'Pintu', 'required|numeric');
        if ($this->form_validation->run() == FALSE) {
            $this->data['user'] = $this->user_model->get_by_id($idUser);
			// $this->data['kos'] = $this->kos_model->get($idUser);
            $this->data['fasilitas'] = $this->db->list_fields('fasilitas');
            $this->data['title'] = 'Add your new kos';
            parent::frontDisplay('kos/add');
        } else {
			$id = guid();
			$input = $this->input->post();
			$input['id'] = $id;
			unset($input['fasilitas']);
			$fasilitas = $this->input->post('fasilitas');
			$fasilitas['id_kos'] = $id;
			$images = $_FILES['img_kos'];
			$this->lib_kos->upload($images, $id); // update image dan inset to table
			$id_insert = $this->kos_model->insert($input);
			if ($id_insert) {
				$this->kos_model->insertFasilitas($fasilitas);
			}
			$this->flashMessage('SUCCESS', 'Berhasil menambah data kos');
            redirect('profile');
        }
    }
}
