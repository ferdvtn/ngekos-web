 <?php
 defined('BASEPATH') OR exit('No direct script access allowed');

    class Beranda extends CI_Controller
    {
        public function __construct()
        {
            parent::__construct();
        }

        public function index()
        {
            return view('Beranda.index', ['nama' => 'ferdian']);
        }
    }

 ?>