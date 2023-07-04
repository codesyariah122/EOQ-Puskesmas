<?php

namespace app\datasources;

use app\helpers\{Helpers};

class UserPrepare {

	public function user_data()
	{

		$helpers = new Helpers;
		return [
			[
				'id' => 1,
				'kd_admin' => 'KU',
				'nm_lengkap' => 'Kepala Balai Kesehatan',
				'alamat' => 'Sekolah TI Al-Musthafawiyah Kec. Me',
				'notlp' => '085921264904',
				'username' => $helpers->generate_username('Kepala Balai Kesehatan'),
				'role' => 'admin',
				'password' => password_hash("admin", PASSWORD_DEFAULT)
			],
			[
				'id' => 2,
				'kd_admin' => 'KU',
				'nm_lengkap' => 'Staf Balai Kesehatan',
				'alamat' => 'Sekolah TI Al-Musthafawiyah Kec. Me',
				'notlp' => '085693171777',
				'username' => $helpers->generate_username('Staf Balai Kesehatan'),
				'role' => 'user',
				'password' => password_hash("user", PASSWORD_DEFAULT)
			],
			[
				'id' => 3,
				'kd_admin' => 'KU',
				'nm_lengkap' => 'Asep Danang',
				'alamat' => 'Sekolah TI Al-Musthafawiyah Kec. Me',
				'notlp' => '081290171787',
				'username' => $helpers->generate_username('Asep Danang'),
				'role' => 'user',
				'password' => password_hash("user", PASSWORD_DEFAULT)
			],
			[
				'id' => 4,
				'kd_admin' => 'KU',
				'nm_lengkap' => 'Dian Minati',
				'alamat' => 'Sekolah TI Al-Musthafawiyah Kec. Me',
				'notlp' => '081293171800',
				'username' => $helpers->generate_username('Dian Minati'),
				'role' => 'user',
				'password' => password_hash("user", PASSWORD_DEFAULT)
			],
			[
				'id' => 5,
				'kd_admin' => 'KU',
				'nm_lengkap' => 'Riki Jiwa',
				'alamat' => 'Sekolah TI Al-Musthafawiyah Kec. Me',
				'notlp' => '089693171870',
				'username' => $helpers->generate_username('Riki Jiwa'),
				'role' => 'user',
				'password' => password_hash("user", PASSWORD_DEFAULT)
			],
			[
				'id' => 6,
				'kd_admin' => 'KU',
				'nm_lengkap' => 'Bambang Saputro',
				'alamat' => 'Sekolah TI Al-Musthafawiyah Kec. Me',
				'notlp' => '085693171873',
				'username' => $helpers->generate_username('Bambang Saputro'),
				'role' => 'user',
				'password' => password_hash("user", PASSWORD_DEFAULT)
			],
			[
				'id' => 7,
				'kd_admin' => 'KU',
				'nm_lengkap' => 'Dea Zulkarnaen',
				'alamat' => 'Sekolah TI Al-Musthafawiyah Kec. Me',
				'notlp' => '085693171871',
				'username' => $helpers->generate_username('Dea Zulkarnaen'),
				'role' => 'user',
				'password' => password_hash("user", PASSWORD_DEFAULT)
			]
		];
	}

}