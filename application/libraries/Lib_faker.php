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

		for ($i=0; $i < 50; $i++) {
			$idkos = guid();
			$datakos[] = [
				// 'id' => $idkos,
				// 'id_pemilik' => '9793ad5957afa26e2ccead062a41b4d2',
				// 'alamat' => $faker->address,
				// 'lat' => '-6.169905253038752',
				// 'lng' => '106.82440210116597',
				// 'judul' => $faker->randomElement($a_judul) . ' ' . $faker->sentence(2),
				// 'luas' => $faker->numberBetween('10', '25'),
				// 'harga' => $faker->numberBetween('20', '200') . '0000',
				// 'pintu' => $faker->numberBetween('1', '8'),
				// 'keterangan' => $faker->text(750),
				// 'created_at' => date("Y-m-d H:i:s"),
				// 'updated_at' => date("Y-m-d H:i:s")
			];
		}

		$this->CI->db->insert_batch('kos', $datakos);
	}


}
