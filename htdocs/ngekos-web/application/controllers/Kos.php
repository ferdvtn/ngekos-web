<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kos extends MY_Controller
{
    public $data = [];

    public function __construct()
    {
        parent::__construct();
        $this->load->model(['kos_model', 'pengajuan_model']);
        $this->load->helper('form');
        $this->load->library(['lib_kos', 'lib_pengajuan', 'check_auth', 'form_validation', 'disqus']);
    }

	// detail
    public function d($id='')
    {
        $idUser = $this->session->userdata('id_user');
        $this->data['user'] = $this->user_model->get_by_id($idUser);
        $this->data['kos'] = $this->kos_model->get_detail($id);
        $this->data['title'] = 'Kos Detail';
        $this->data['disqus'] =  $this->disqus->get_html();
		$this->data['kos_terbaru'] = $this->db->select('kos.*, user.nama as pemilik, user.no_handphone, user.alamat as alamat_pemilik')
									->from('kos')->order_by('created_at', 'DESC')->limit(4)
									->join('user', 'user.id_user = kos.id_user')
									->get()->result();
        if (empty($this->data['kos'])) {
            $this->flashMessage('ERROR', 'alaman yang anda cari tidak ditemukan!');
            redirect(base_url('/'));
		}
        parent::frontDisplay('kos/detail');
    }

    public function update()
    {
        $this->check_auth->is_logged_in();
        $id = $this->input->get('id');
        if (empty($id)) {
            $id = $this->input->post('id_kos');
        }
        $idUser = $this->session->userdata('id_user');
        $this->form_validation->set_rules('judul', 'Title', 'required|min_length[5]|max_length[50]');
        $this->form_validation->set_rules('alamat', 'Alamat', 'required|min_length[10]');
        $this->form_validation->set_rules('luas', 'Luas', 'required|max_length[5]|numeric');
        $this->form_validation->set_rules('harga', 'Harga', 'required|numeric');
        $this->form_validation->set_rules('pintu', 'Pintu', 'required|numeric');
        if ($this->form_validation->run() == FALSE) {
			$cek_kepemilikan = $this->lib_kos->ownershipCheck($id, $this->session->userdata('id_user'));
            if ($cek_kepemilikan == false) {
                $this->flashMessage('ERROR', 'Halaman yang anda cari tidak ditemukan!');
                redirect(base_url("kos/d/$id"));
            }
            $this->data['title'] = 'Update kosan';
            $this->data['user'] = $this->user_model->get_by_id($idUser);
			$this->data['kos'] = $this->kos_model->get_detail($id);
            $this->data['fasilitas'] = $this->db->list_fields('fasilitas');
            parent::frontDisplay('kos/edit');
        } else {
			$input = $this->input->post();
			unset($input['fasilitas']);
			$input_fasilitas = $this->input->post('fasilitas');
			$images = $_FILES['img_kos'];
			$this->lib_kos->upload($images, $id); // update image dan inset to table
			$update_kos = $this->kos_model->update($input, 'id_kos');
			if ($update_kos) {
				$input_fasilitas['id_kos'] = $id;
				$this->kos_model->updateFasilitas($input_fasilitas);
			}
			$this->flashMessage('SUCCESS', 'Data kos anda telah diperbaharui!');
            redirect(base_url("kos/d/$id"));
        }
    }

    public function delete()
    {
        $id = $this->input->get('id');
        $cek_kepemilikan = $this->lib_kos->ownershipCheck($id, $this->session->userdata('id_user'));
        if ($cek_kepemilikan == false) {
            $this->flashMessage('ERROR', 'Halaman tidak ditemukan!');
            redirect($_SERVER['HTTP_REFERER']);
        }
        $this->kos_model->delete('id_kos',$id);
        $this->flashMessage('SUCCESS', 'Data kos telah dihapus!');
        redirect(go_back());
	}

	public function delete_images()
	{
		$id = $this->input->get('id');
		if ($this->kos_model->delete_image($id) != false) {
			$this->flashMessage('SUCCESS', 'Berhasil menghapus foto');
		} else {
			$this->flashMessage('ERROR', 'Halaman tidak ditemukan');
		}
		redirect(go_back());
	}

    public function pengajuan()
    {
        $this->check_auth->is_logged_in();
        $id_pengaju = $this->session->userdata('id_user');
        $input = $this->input->post();
        $cek_pengajuan = $this->lib_pengajuan->submissionCheckIsExists($input['id_kos'], $id_pengaju);
        if ($cek_pengajuan == true) {
            $this->flashMessage('ERROR', 'Anda telah mengajukan pengajuan!');
            redirect(base_url("kos/d/$input[id_kos]"));
		}
        $cek_kepemilikan = $this->lib_kos->ownershipCheck($input['id_kos'], $input['id_user']);
        if ($cek_kepemilikan == false) {
            $this->flashMessage('ERROR', 'Halaman tidak ditemukan!');
            redirect(base_url("kos/d/$input[id_kos]"));
		}

		$kos = $this->kos_model->get_detail($input['id_kos']);

		if (isset($kos)) {
			$_id = guid();
            $this->form_validation->set_rules('penghuni', 'Jumlah penghuni', 'required|numeric|max_length[2]');
            if ($this->form_validation->run() != false) {
                $rows = [
					'id_pengajuan' => $_id,
                    'id_user_pemilik' => $input['id_user'],
                    'id_user_pengaju' => $id_pengaju,
                    'id_kos' => $input['id_kos'],
                    'penghuni' => $input['penghuni'],
                    'keterangan' => $input['keterangan']
				];
                $this->pengajuan_model->insert($rows);
                $this->flashMessage('SUCCESS', 'Pengajuan anda telah disampaikan kepada pemilik!');
            } else {
                $this->flashMessage('ERROR', 'Periksa kembali data yang anda masukan!');
                redirect(base_url("kos/d/$input[id_kos]"));
            }
		} else $this->flashMessage('ERROR', 'Terjadi kesalahan saat pengajuan!');

        redirect(go_back());
    }
}