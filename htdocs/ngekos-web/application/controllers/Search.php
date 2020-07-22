<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Search extends MY_Controller {
    public $data = [];

    public function __construct()
    {
        parent::__construct();
        $this->load->model(['user_model', 'kos_model']);
        $this->load->library('lib_kos');
        $this->load->helper(['form', 'url']);
    }

    public function index()
    {
        $q = $this->input->get('q');
        $adr = $this->input->get('adr');
        $q = array_values(array_filter(explode(' ', $q)));
        $adr = array_values(array_filter(explode(' ', $adr)));

        if (empty($q) && empty($adr)) {
            redirect(base_url('/'));
        }

        $idUser = $this->session->userdata('id_user');
        $this->data['user'] = $this->user_model->get_by_id($idUser);
        $this->data['kos'] = $this->kos_model->search($q, $adr);
        $this->data['title'] = "Home | Ngekos";
        parent::frontDisplay('front-index');
    }

}