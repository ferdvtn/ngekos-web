<?php

class User_model extends CI_Model{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
    }

    public function get($data = NULL)
    {
        if ($data != NULL)
        {
            $query = $this->db->get_where('user', ['email' => $data['email']]);
            return $query->row_array();
        }
        else
        {
            $query = $this->db->get('user');
            return $query->result_array();
        }
    }

    public function get_by_id($id)
    {
        $query = $this->db->get_where('user', ['id' => $id]);
        return $query->row_array();
    }

    public function update_password($rows)
    {
        $id = $this->session->userdata('id');
        $currentPassword = $rows['current_password'];
        $newPassword = password_hash($rows['new_password1'], PASSWORD_DEFAULT);
        $oldPassword = $this->db->get_where('user', ['id' => $id])->row_array()['password'];
        if (password_verify($currentPassword, $oldPassword))
        {
            $data = [
                'password' => $newPassword,
            ];
            $this->db->update('user', $data, ['id' => $id]); # (table, data, where)
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }

    public function update($data)
    {
        $newData = [
            'nama' => $data['nama'],
            'email' => $data['email'],
            'no_handphone' => $data['no_handphone'],
            'alamat' => $data['alamat'],
        ];
        $idUser = $this->session->userdata('id');
        $this->db->where('id', $idUser);
        $this->db->update('user', $newData);
        $this->session->set_userdata(['email' => $data['email']]);
	}

	public function update_pict($namefile, $id)
	{
		$this->db->set('user_picture', $namefile);
		$this->db->where('id', $id);
		$this->db->update('user');
		return $id;
	}
}