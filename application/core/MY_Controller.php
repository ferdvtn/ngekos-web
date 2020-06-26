<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{
    public function __construct()
    {
		parent::__construct();
    }

    public function flashMessage($code, $message)
    {
        switch ($code) {
            case 'SUCCESS':
                $class = 'alert-success'; break;

            case 'ERROR':
                $class = 'alert-danger'; break;

            case 'WARNING':
                $class = 'alert-warning'; break;

            default:
                $class = 'alert-info'; break;
        }
        $this->session->set_flashdata('class', $class);
        $this->session->set_flashdata('flashdata', $message);
    }

    public function get_pengajuan()
    {
        $id_user = !empty($this->session->userdata('id')) ? $this->session->userdata('id') : '';
        $this->load->library('lib_pengajuan');
        $my_notif = $this->lib_pengajuan->getByUser($id_user);
        return $my_notif;
    }

    public function status_pengajuan()
    {
        $id_user = !empty($this->session->userdata('id')) ? $this->session->userdata('id') : '';
        $this->load->library('lib_status_pengajuan');
        $status = $this->lib_status_pengajuan->getByUser($id_user);
        return $status;
	}

	/**
	 * tampilan bagian public
	 *
	 * @param text $view_name
	 * @return view
	 */
    public function frontDisplay($view_name)
    {
        $this->data['notif'] = $this->get_pengajuan();
		$this->data['status_pengajuan'] = $this->status_pengajuan();
		$this->data['user_pic'] = BASE_URL("assets/img/user-default.png");
		if (!empty($this->data['user']['user_picture'])) {
			$this->data['user_pic'] = BASE_URL() . "assets/img/user/" . $this->data['user']['id'] . "/" . $this->data['user']['user_picture'];
		}

        $this->load->view('templates/front-header', $this->data);
        $this->load->view('templates/notification', $this->data);

        if (is_array($view_name)) {
            foreach ($view_name as $vn) {
                $this->load->view($vn, $this->data);
            }
        } else {
            $this->load->view($view_name, $this->data);
        }
        $this->load->view('templates/front-footer');
	}

	/**
	 * tampilan bagian auth
	 *
	 * @param text $view_name
	 * @return view
	 */
    public function authDisplay($view_name)
    {
        $this->data['notif'] = $this->get_pengajuan();
		$this->data['status_pengajuan'] = $this->status_pengajuan();
		$this->data['user_pic'] = BASE_URL("assets/img/user-default.png");
		if (!empty($this->data['user']['user_picture'])) {
			$this->data['user_pic'] = BASE_URL() . "assets/img/user/" . $this->data['user']['id'] . "/" . $this->data['user']['user_picture'];
		}

        $this->load->view('templates/auth-header', $this->data);

        if (is_array($view_name)) {
            foreach ($view_name as $vn) {
                $this->load->view($vn, $this->data);
            }
        } else {
            $this->load->view($view_name, $this->data);
        }
        $this->load->view('templates/auth-footer');
    }
}
