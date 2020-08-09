<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Lib_faker {

	public $CI;

	public function __construct()
	{
		$this->CI =& get_instance();
	}

	public function get()
	{
		$faker = Faker\Factory::create('id_ID');
		$datakos = [];
		$a_judul = ['Kos', 'Kosan', 'Apartemen', 'Kontrakan', 'Perumahan', 'Rumah', 'Home stay', 'Saung', 'Hotel', 'Rusun', 'Rumah susun', 'Sewa', 'Penginapan'];
		$idusers = ['3b1e33c839cf7c64f1c29d0d51cb1cc3', 'f1ba5d9ce081d91c359da8d32304436d', '2c04e86dc2bd27646163abace55b7935', '2152b4c0aefcf7c4b4ba4562ef8a2f82', '5b124ac4c0e87369b41ffea5a8e4a574'];
		for ($i=0; $i < 50; $i++) {
			$idkos = guid();
			$datakos[] = [
				'id_kos' => $idkos,
				'id_user' => $faker->randomElement($idusers),
				'alamat' => $faker->address,
				'lat' => '-6.169905253038752',
				'lng' => '106.82440210116597',
				'judul' => $faker->randomElement($a_judul) . ' ' . $faker->sentence(2),
				'luas' => $faker->numberBetween('10', '25'),
				'harga' => $faker->numberBetween('35', '100') . '0000',
				'pintu' => $faker->numberBetween('1', '5'),
				'keterangan' => $faker->text(750),
				'created_at' => date("Y-m-d H:i:s"),
				'updated_at' => date("Y-m-d H:i:s")
			];
		}

		// $this->CI->db->insert_batch('kos', $datakos);
	}


}
