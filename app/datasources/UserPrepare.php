<?php

namespace app\datasources;

class UserPrepare {


	public function user_data()
	{
		return [
			[
				'id' => 1,
				'kd_admin' => 'KU',
				'nm_lengkap' => 'Kepala Balai Kesehatan',
				'alamat' => 'Sekolah TI Al-Musthafawiyah Kec. Me',
				'notlp' => '085921264904',
				'username' => 'admin',
				'password' => password_hash("admin", PASSWORD_DEFAULT)
			],
			[
				'id' => 2,
				'kd_admin' => 'KU',
				'nm_lengkap' => 'Staf Balai Kesehatan',
				'alamat' => 'Sekolah TI Al-Musthafawiyah Kec. Me',
				'notlp' => '085693171879',
				'username' => 'user',
				'password' => password_hash("user", PASSWORD_DEFAULT)
			]
		];
	}

}