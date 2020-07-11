<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends MY_Controller
{
	public $data = [];

    public function __construct()
    {
        parent::__construct();
        $this->load->library(['form_validation', 'check_auth']);
        $this->load->model('user_model');
    }

    public function index() # LOGIN
    {
        $this->check_auth->is_not_logged_in();
        $this->data['title'] = 'Login';
        if (empty($this->session->userdata('kos')) && !empty($this->input->get('kos'))) {
            $this->session->set_userdata([
                'kos' => $this->input->get('kos')
            ]);
        }

        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'required');
        if($this->form_validation->run() == false)
        {
			parent::authDisplay('auth/login');
        }
        else
        {
            $dataUser = $this->input->post();
            $getUser = $this->user_model->get($dataUser);
            // CEK EMAIL
            if ($dataUser['email'] == $getUser['email'])
            {
                // CEK PASSWORD
                if (password_verify($dataUser['password'], $getUser['password']))
                {
                    $this->session->set_userdata([
                        'id' => $getUser['id'],
                    ]);
                    if (!empty($this->session->userdata('kos'))) {
                        $kos = $this->session->userdata('kos');
                        unset($_SESSION['kos']);
                        redirect("kos?id=$kos");
                    } else{
                        redirect('main');
                    }
                }
                else
                {
					$this->flashMessage("ERROR", "Password Salah!");
					parent::authDisplay('auth/login');
                }
            }
            else
            {
                $this->flashMessage("ERROR", "Email tidak ditemukan!");
				parent::authDisplay('auth/login');
            }
        }
    }

    public function register()
    {
        $this->check_auth->is_not_logged_in();
        $this->data['title'] = 'Register';
        $this->form_validation->set_rules('name', 'Name', 'required|min_length[2]|max_length[50]');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[user.email]');
        $this->form_validation->set_rules('no_handphone', 'Phone Number', 'required|numeric');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[3]|matches[password1]');
        $this->form_validation->set_rules('password1', 'Confirm Password', 'required|min_length[3]|matches[password]');
        if($this->form_validation->run() == false)
        {
			parent::authDisplay('auth/register');
        }
        else
        {
            $data = [
				'id' => guid(),
                'nama' => ucfirst(htmlspecialchars($this->input->post('name'))),
                'email'=> $this->input->post('email'),
                'no_handphone'=> $this->input->post('no_handphone'),
                'password'=> password_hash($this->input->post('password'), PASSWORD_DEFAULT)
            ];
            $this->db->insert('user', $data);
            $this->flashMessage('SUCCESS', 'Register success, please Login!');
            redirect('login');
        }
    }

    public function change_password()
    {
        $this->check_auth->is_logged_in();
        $id = $this->session->userdata('id');
        $this->data['user'] = $this->user_model->get_by_id($id);
        $this->data['title'] = "Change Password";
        // VALIDASI
        $this->form_validation->set_rules('current_password', 'Current Password', 'required|differs[new_password1]|differs[new_password2]');
        $this->form_validation->set_rules('new_password1', 'New Password', 'required|min_length[3]|matches[new_password2]');
        $this->form_validation->set_rules('new_password2', 'Password Verify', 'required|min_length[3]|matches[new_password1]');
        if ($this->form_validation->run() === FALSE) # JIKA BELUM DISUBMIT
        {
			parent::frontDisplay('change_password');
        }
        else # JIKA SUDAH DISUBMIT
        {
            $q = $this->input->post();
            if($this->user_model->update_password($q))
            {
                $this->flashMessage('SUCCESS', 'Password success to change!');
                redirect('main');
            }
            else # JIKA PASSWORD SALAH
            {
                $this->flashMessage('ERROR', 'Wrong Password!');
                redirect('auth/change_password');
            }
        }
    }

    public function logout()
    {
        $this->session->unset_userdata(['id', 'email']);
        redirect('Auth');
    }
}