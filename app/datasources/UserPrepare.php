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
				'alamat' => trim('Sekolah TI Al-Musthafawiyah Kec. Me'),
				'notlp' => $helpers->formatPhoneNumber('085921264904'),
				'username' => 'admin01',
				'role' => 'admin',
				'password' => password_hash("admin", PASSWORD_DEFAULT)
			],
			[
				'id' => 2,
				'kd_admin' => 'KU',
				'nm_lengkap' => 'Staf Balai Kesehatan',
				'alamat' => trim('Sekolah TI Al-Musthafawiyah Kec. Me'),
				'notlp' => $helpers->formatPhoneNumber('085693171777'),
				'username' => 'staf01',
				'role' => 'user',
				'password' => password_hash("user", PASSWORD_DEFAULT)
			],
			[
				'id' => 3,
				'kd_admin' => 'KU',
				'nm_lengkap' => 'Asep Danang',
				'alamat' => trim('Jl. Toraja No.19 Rt.03/Rw.04'),
				'notlp' => $helpers->formatPhoneNumber('081290171787'),
				'username' => $helpers->generateUsernameFromName('Asep Danang'),
				'role' => 'user',
				'password' => password_hash("user", PASSWORD_DEFAULT)
			],
			[
				'id' => 4,
				'kd_admin' => 'KU',
				'nm_lengkap' => 'Dian Minati',
				'alamat' => trim('Jl. Kemuning No.10'),
				'notlp' => $helpers->formatPhoneNumber('081293171800'),
				'username' => $helpers->generateUsernameFromName('Dian Minati'),
				'role' => 'user',
				'password' => password_hash("user", PASSWORD_DEFAULT)
			],
			[
				'id' => 5,
				'kd_admin' => 'KU',
				'nm_lengkap' => 'Riki Jiwa',
				'alamat' => trim('Jl. Sekarwati No.11'),
				'notlp' => $helpers->formatPhoneNumber('089693171870'),
				'username' => $helpers->generateUsernameFromName('Riki Jiwa'),
				'role' => 'user',
				'password' => password_hash("user", PASSWORD_DEFAULT)
			],
			[
				'id' => 6,
				'kd_admin' => 'KU',
				'nm_lengkap' => 'Bambang Saputro',
				'alamat' => trim('Jl. Ananda 45 Blok G1'),
				'notlp' => $helpers->formatPhoneNumber('085693171873'),
				'username' => $helpers->generateUsernameFromName('Bambang Saputro'),
				'role' => 'user',
				'password' => password_hash("user", PASSWORD_DEFAULT)
			],
			[
				'id' => 7,
				'kd_admin' => 'KU',
				'nm_lengkap' => 'Dea Zulkarnaen',
				'alamat' => trim('Jl. Kemuning No. 21'),
				'notlp' => $helpers->formatPhoneNumber('085693171871'),
				'username' => $helpers->generateUsernameFromName('Dea Zulkarnaen'),
				'role' => 'user',
				'password' => password_hash("user", PASSWORD_DEFAULT)
			]
		];
	}

}