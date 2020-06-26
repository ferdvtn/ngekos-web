<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Check_auth {

    protected $CI;

    public function __construct()
    {
        $this->CI =& get_instance();
        $this->CI->load->model('user_model');
    }

    public function is_logged_in()
    {
        if ($this->CI->session->has_userdata('id') === TRUE) # jika sudah login
        {
            return True;
        }
        else
        {
            // $this->CI->session->set_flashdata('flashError', 'Sorry, Your not logged in!');
            redirect('login');
        }
    }

    public function is_not_logged_in()
    {
        if ($this->CI->session->has_userdata('id') === FALSE) # jika belum login
        {
            return True;
        }
        else
        {
            redirect('home');
        }
    }
}