<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Dev extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->library('lib_faker');
    }

    public function index()
    {
        // $data = $this->lib_faker->get();
    }

}