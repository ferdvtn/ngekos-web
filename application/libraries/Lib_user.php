<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lib_user {

    protected $CI;

    public function __construct()
    {
        $this->CI =& get_instance();
		$this->CI->load->model(['user_model']);
	}

	public function change_picture($file, $id)
	{
		$this->CI->db->select('*');
		$this->CI->db->from('user');
		$this->CI->db->where('id', $id);
		$get_user = $this->CI->db->get();
		if ($get_user->num_rows() > 0) {
			$path = './assets/img/user/'.$id;
			if (!file_exists($path)) {
				mkdir($path, 0777, true);
			}
			$config = array();
			$config['upload_path'] = $path;
			$config['allowed_types'] = 'jpg|png|jpeg';
			$config['max_size']      = '200000';
			$config['overwrite']     = TRUE;

			$this->CI->load->library('upload', $config);
			if ($this->CI->upload->do_upload('profile_pict')) {
				$images_name = $this->CI->upload->data('file_name');
				$this->CI->user_model->update_pict($images_name, $id);
				return $images_name;
			} else return false;

		}
	}

	/**
	 * gpp : get profile picture
	 * mendapatkan nama picture profile by id
	 *
	 * @param string $user_id
	 * @return string
	 */
	public function gpp($user_id)
	{
		$this->CI->db->select('user_picture');
		$this->CI->db->from('user');
		$this->CI->db->where('id', $user_id);
		$result = $this->CI->db->get();
		if ($result->num_rows() > 0) {
			$result = $result->first_row();
			if (empty($result->user_picture)) {
				$result->user_picture = '../../user-default.png';
			}
		}
		$r = $result->user_picture;

		return $r;
	}
}