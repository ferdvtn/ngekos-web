<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lib_kos {

    protected $CI;

    public function __construct()
    {
        $this->CI =& get_instance();
		$this->CI->load->model(['user_model', 'kos_model', 'tersewa_model']);
		$this->CI->load->helper(array('form', 'url'));
    }

    /**
     * mendapatkan total jumlah kamar kos
     */
    public function getKos()
    {
        $idUser = $this->CI->session->userdata('id');
        $data = $this->CI->kos_model->get($idUser);
		$pintu = 0;
		if (!empty($data)) {
			foreach ($data as $kos) {
				$temp = (int)$kos->pintu;
				$pintu = $pintu + $temp;
			}
			return $pintu;
		}
    }

    /**
     * Mendapatkan jumlah kamar yang tersisa
     */
    public function getTersewa()
    {

        $idUser = $this->CI->session->userdata('id');
        $tersewa = $this->CI->kos_model->getTersewa($idUser);
        return $tersewa;
    }

    /**
     * return int nilai kosan yang tersisa berdasarkan jumlah kosan - jumlah yang tersewa
     */
    public function getTersisa()
    {
        $idUser = $this->CI->session->userdata('id');
        $tersewa = $this->CI->kos_model->getTersewa($idUser);
        $sisaKosan = $this->getKos() - $tersewa;
        return $sisaKosan;
    }

    /**
     * return int nilai kosan yang tersisa berdasarkan jumlah pintung kosan/kosan - jumlah yang tersewa
     */
    public function hitungsisa($idKos, $kosPintuPerItem)
    {
        // $idUser = $this->CI->session->userdata('id');
        $tersisaPerItem = $this->CI->tersewa_model->getTotalTersewa($idKos);
        $sisa = $kosPintuPerItem - $tersisaPerItem;
        return $sisa;
    }

    /**
     * cek kepemilikan kos
     */
    public function ownershipCheck($id_kos, $id_pemilik)
    {
        $detail = [
            'id' => $id_kos,
            'id_pemilik' => $id_pemilik
        ];
        $this->CI->db->select('*');
        $this->CI->db->from('kos');
        $this->CI->db->where($detail);
        $result = $this->CI->db->get();
        if ($result->num_rows() > 0) return true;
        else return false;
	}

	public function upload($images, $id_kos)
	{
		$path = './assets/img/kos/'.$id_kos;
		if (!file_exists($path)) {
			mkdir($path, 0777, true);
		}
		$config = array();
		$config['upload_path'] = $path;
		$config['allowed_types'] = 'jpg|png|jpeg';
		$config['max_size']      = '200000';
		$config['overwrite']     = FALSE;

		/** cek total images yg udah ada di database */
		$this->CI->db->select('*');
		$this->CI->db->from('kos_images');
		$this->CI->db->where('id_kos', $id_kos);
		$result = $this->CI->db->get();
		$total_in_db = $result->num_rows();
		$total_sisa = 5 - $total_in_db; // 5 adalah angka maksimal images kos

		if (!empty($images['name'][0])) {
			$total = count($images['name']);
			for($i=0; $i < $total; $i++)
			{
				if ($i == $total_sisa) {
					break;
				}
				$_FILES = [];
				$this->CI->load->library('upload', $config);
				$_FILES['img_kos']['name'] = $images['name'][$i];
				$_FILES['img_kos']['type'] = $images['type'][$i];
				$_FILES['img_kos']['tmp_name'] = $images['tmp_name'][$i];
				$_FILES['img_kos']['error'] = $images['error'][$i];
				$_FILES['img_kos']['size'] = $images['size'][$i];
				if ($this->CI->upload->do_upload('img_kos')) {
					$images_name[] = $this->CI->upload->data('file_name');
				}
			}
			if (!empty($images_name)) {
				$this->CI->kos_model->insert_images($images_name, $id_kos);
			}
		}
	}
}