<?php

class Kos_model extends MY_Model{

    public function __construct()
    {
        $this->controller_name = __CLASS__;
        $this->table_name = 'kos';
        parent::__construct();
    }

    public function get($id = null, $limit = '')
    {
        if ($id==null) {
			$this->db->select('kos.*, user.nama as pemilik, user.no_handphone, user.alamat as alamat_pemilik');
			$this->db->from('kos');
			$this->db->join('user', 'user.id = kos.id_pemilik');
			$this->db->order_by('updated_at', 'DESC');
			if (!empty($limit)) {
				$this->db->limit($limit);
			}

			$data = $this->db->get();
			if ($data->num_rows() > 0) {
				$data = $data->result();

				// mengambil gambar dari kos
				$this->db->select('*');
				$this->db->from('kos_images');
				$data_images = $this->db->get();
				if ($data_images->num_rows() > 0) {
					$data_images = $data_images->result();
					foreach ($data as $idx => $val_d) {
						$data[$idx]->title = [];
						foreach ($data_images as $di) {
							if ($val_d->id == $di->id_kos) {
								$data[$idx]->title[] = $di->title;
							}
						}
					}
				}
					return $data;
			}
        } else {
            $this->db->select('*');
			$this->db->from('kos');
			$this->db->where('id_pemilik', $id);
			$this->db->order_by('updated_at', 'DESC');
			$data = $this->db->get();
			if ($data->num_rows() > 0) {
				$data = $data->result();
				return $data;
			}
        }
	}

	/**
	 * mengambil data kos beserta penyewanya
	 *
	 * @return array
	 */
	public function getPenyewa($id)
	{
		$this->db->select('kos.*, tersewa.id_penyewa AS id_penyewa, tersewa.id AS id_tersewa, user.nama as nama_penyewa');
		$this->db->from('kos');
		$this->db->where('id_pemilik', $id);
		$this->db->join('tersewa', 'tersewa.id_kos = kos.id');
		$this->db->join('user', 'user.id = tersewa.id_penyewa');
		$data = $this->db->get();
		if ($data->num_rows() > 0) {
			$data = $data->result();
			return $data;
		}
	}

    /**
     * mengambil nilai berapa banyak orang yang menyewa/pintu kosan suatu user
     */
    public function getTersewa($id)
    {
        // mengambil data kosan milik sendiri
        $this->db->select('*');
        $this->db->from('kos');
        $this->db->where('id_pemilik', $id);
        $data = $this->db->get()->result();
        // mengambil jumlah data penyewa per pintu
        $dataFinal = [];
        foreach ($data as $data) {
            $this->db->select('*');
            $this->db->from('tersewa');
            $this->db->where('id_kos', $data->id);
            $dataFinal[] = $this->db->get()->result();
        }
        $hitung = 0;
        foreach ($dataFinal as  $dataFinal) {
            $hitung += count($dataFinal);
        }
        return $hitung;
    }

    public function search($q='', $adr='')
    {
        $_q = [];
        foreach ($q as $val) {
            $_q[] = "judul LIKE '%$val%'";
        }
        $q ='(' . implode(' OR ', $_q) . ')';

        $_adr = [];
        foreach ($adr as $val) {
            $_adr[] = "kos.alamat LIKE '%$val%'";
        }
        $adr ='(' . implode(' OR ', $_adr) . ')';

		$this->db->select('kos.*, user.nama as pemilik, user.no_handphone, user.alamat as alamat_pemilik');
		$this->db->from('kos AS kos');
		$this->db->join('user', 'user.id = kos.id_pemilik');
        if ($q !== '()') $this->db->where($q);
        if ($adr !== '()') $this->db->where($adr);
        $results = $this->db->get();
        return $results->result();
    }

    public function get_detail($id)
    {
        $this->db->select('kos.*, user.nama as pemilik, user.no_handphone, user.alamat as alamat_pemilik');
        $this->db->from('kos');
        $this->db->join('user', 'user.id = kos.id_pemilik');
        $this->db->where('kos.id', $id);
		$data = $this->db->get();
		if ($data->num_rows() > 0) {
			$data = $data->first_row();
			$data->fasilitas = new stdClass();

			// mengambil gambar dari kos
			$this->db->select('*');
			$this->db->from('kos_images');
			$data_images = $this->db->get();
			if ($data_images->num_rows() > 0) {
				$data_images = $data_images->result();
				$data->title = [];
				foreach ($data_images as $di) {
					if ($data->id == $di->id_kos) {
						$data->title[$di->id] = $di->title;
					}
				}
			}

			$this->db->select('fas.*');
			$this->db->from('fasilitas AS fas');
			$this->db->where('fas.id_kos', $id);
			$fass = $this->db->get();
			if ($fass->num_rows() > 0) {
				$fas = $fass->first_row();
				$data->fasilitas = $fas;
			}

			return $data;
		}

    }

    public function insert($rows)
    {
        return parent::insert($rows);
	}

    public function insert_images($images, $id_kos)
    {
		foreach ($images as $idx => $image) {
			$new_images[$idx] = [
				'id' => guid(),
				'id_kos' => $id_kos,
				'title' => $image
			];
		}
		$this->db->insert_batch('kos_images', $new_images);
    }

    public function update($rows)
    {
		return parent::update($rows);
    }

    public function delete($id)
    {
        parent::delete($id);
	}

	public function delete_image($id_image)
	{
		$this->db->select('*');
		$this->db->from('kos_images');
		$this->db->where('id', $id_image);
		$result = $this->db->get();
		if ($result->num_rows() > 0) {
			$result = $result->first_row();
			unlink(APPPATH . "../assets/img/kos/$result->id_kos/$result->title");
			$this->db->where('id', $id_image);
			$this->db->delete('kos_images');
			return TRUE;
		} else return FALSE;
	}

	public function insertFasilitas($fasilitas)
	{
		$input = $this->formatingFas($fasilitas);
		$input['created_at'] = date("Y-m-d H:i:s");
		$input['updated_at'] = date("Y-m-d H:i:s");

		$this->db->insert('fasilitas', $input);

		return $input['id_kos'];
	}

	public function updateFasilitas($fasilitas)
	{
		$cek = $this->db->select('id_kos')->from('fasilitas')->where('id_kos', $fasilitas['id_kos'])->get();
		if ($cek->num_rows() > 0) {
			$input = $this->formatingFas($fasilitas);
			$input['updated_at'] = date("Y-m-d H:i:s");

			$this->db->where('id_kos', $input['id_kos']);
			$this->db->update('fasilitas', $input);

			return $input['id_kos'];
		} else {
			return $this->insertFasilitas($fasilitas);
		}
	}

	public function formatingFas($fasilitas)
	{
		$result = $this->db->list_fields('fasilitas');
		foreach ($result as $res) {
			if ($res != 'id_kos' && ($res != 'created_at' && ($res != 'updated_at'))) {
				if (isset($fasilitas[$res])) {
					$fasilitas[$res] = 1;
				} else {
					$fasilitas[$res] = 0;
				}
			}
		}
		return $fasilitas;
	}
}