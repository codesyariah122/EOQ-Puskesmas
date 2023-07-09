<?php
/**
 * File: Helpers.php
 * @author Puji Ermanto <pujiermanto@gmail.com>
 * Description: File ini berisi berbagai fungsi bantu (helper functions).
**/

namespace app\helpers;


class Helpers {

	public function __construct()
	{
		
	}

	/**
     * Memeriksa apakah pengguna menggunakan perangkat mobile.
     *
     * @return bool True jika pengguna menggunakan perangkat mobile, false jika tidak.
     */
	public function isMobileDevice() {
		$userAgent = $_SERVER['HTTP_USER_AGENT'];
		$mobileKeywords = ['Mobile', 'Android', 'iPhone', 'iPad', 'Windows Phone']; 

		foreach ($mobileKeywords as $keyword) {
			if (stripos($userAgent, $keyword) !== false) {
				return true;
			}
		}

		return false;
	}

	
	 /**
	 * Menghasilkan token acak.
	 *
	 * @return string Token acak yang dihasilkan.
	 */

	public function generate_token() 
	{
	    $length = 32; // Panjang token dalam byte
	    $token = bin2hex(random_bytes($length)); // Menggunakan random_bytes() untuk menghasilkan token acak
	    return $token;
	}

	/**
     * Menghasilkan username dari nama lengkap.
     *
     * @param string $name Nama lengkap pengguna.
     * @return string Username yang dihasilkan.
     */
	public function generate_username($name) 
	{
		$namaLengkap = $name; // Nama lengkap pengguna

		// Pisahkan nama lengkap menjadi kata-kata individu
		$kataKata = explode(" ", $namaLengkap);

		// Buat username dari inisial kata-kata
		$username = "";
		foreach ($kataKata as $kata) {
			$inisial = substr($kata, 0, 1);
			$username .= strtolower($inisial);
		}

		// Generate angka acak 2 digit
		$angkaAcak = str_pad(mt_rand(0, 99), 2, "0", STR_PAD_LEFT);

		// Gabungkan username dengan angka acak
		$username .= $angkaAcak;

		return $username;
	}


	/**
     * Validasi nomor telepon.
     *
     * @param string $phoneNumber Nomor telepon yang akan divalidasi.
     * @return bool True jika nomor telepon valid, false jika tidak valid.
     */
	function validatePhoneNumber($phoneNumber) {
  		// Hapus karakter selain angka
		$phoneNumber = preg_replace('/[^0-9]/', '', $phoneNumber);

  		// Cek panjang nomor telepon
		if (strlen($phoneNumber) < 10 || strlen($phoneNumber) > 12) {
			return false;
		}

  		// Cek apakah nomor telepon diawali dengan angka 0 atau +62
		if (!preg_match('/^(0|\+62)/', $phoneNumber)) {
			return false;
		}

  		// Cek apakah nomor telepon hanya terdiri dari angka setelah dihapus karakter selain angka
		if (!preg_match('/^[0-9]+$/', $phoneNumber)) {
			return false;
		}

		return true;
	}


	 /**
     * Memformat nomor telepon.
     *
     * @param string $nohp Nomor telepon yang akan diformat.
     * @return string|false Nomor telepon yang diformat atau false jika nomor telepon tidak valid.
     */
	public function formatPhoneNumber($nohp)
    {
        // kadang ada penulisan no hp 0811 239 345
        $nohp = str_replace(" ", "", $nohp);
        // kadang ada penulisan no hp (0274) 778787
        $nohp = str_replace("(", "", $nohp);
        // kadang ada penulisan no hp (0274) 778787
        $nohp = str_replace(")", "", $nohp);
        // kadang ada penulisan no hp 0811.239.345
        $nohp = str_replace(".", "", $nohp);
        // kadang ada penulisan no hp 0811-239-345
        $nohp = str_replace("-", "", $nohp);
        // cek apakah no hp mengandung karakter + dan 0-9
        if (!preg_match('/[^+0-9]/', trim($nohp))) {
            // cek apakah no hp karakter 1-3 adalah +62
            if (substr(trim($nohp), 0, 1) == '+') {
                $hp = '' . substr(trim($nohp), 1);
            } elseif (substr(trim($nohp), 0, 2) == '62') {
                $hp = trim($nohp);
            } elseif (substr(trim($nohp), 0, 1) == '0') {
                $hp = '62' . substr(trim($nohp), 1);
            }
        } else {
            return false;
        }
        // var_dump($nohp); die;
        return $hp;
    }

    /**
     * Format a phone number for editing.
     * @author Puji Ermanto <pujiermanto@gmail.com>
     * @param string $phoneNumber The phone number to format.
     * @return void
     */
    public function formatPhoneEdit($phoneNumber)
    {
    	// Mengambil 3 karakter pertama
    	$prefix = substr($phoneNumber, 0, 2);

		// Jika prefixnya adalah '628', maka hilangkan prefix tersebut
    	if ($prefix === '62') {
    		$formattedNumber = '0' . substr($phoneNumber, 2);
    	} else {
    		$formattedNumber = $phoneNumber;
    	}

    	echo $formattedNumber;
    }

    /**
     * Format a number to Indonesian Rupiah currency format.
     * @author Puji Ermanto <pujiermanto@gmail.com> 
     * @param float $num The number to format.
     * @return string The formatted number.
     */
    public function formatRupiah($num)
    {
    	$rupiah = number_format($num, 0, ',', '.');

		return $rupiah; // Output: Rp 1.500.000

    }

    /**
     * Generate a username from a name.
     * @author Puji Ermanto <pujiermanto@gmail.com> 
     * @param string $fullname The full name.
     * @return string The generated username.
     */
    public function generateUsernameFromName($fullname)
    {
    	$namaLengkap = $fullname;

		// Mengubah nama lengkap menjadi array kata
    	$namaArray = explode(' ', $namaLengkap);

		// Mengambil kata terakhir sebagai nama pengguna
    	$namaPengguna = end($namaArray);

		// Mengubah nama pengguna menjadi lowercase
    	$namaPengguna = strtolower($namaPengguna);

		// Menghapus spasi pada nama pengguna
    	$namaPengguna = str_replace(' ', '', $namaPengguna);

		// Menambahkan angka acak dari 1 sampai 99
    	$angkaAcak = rand(1, 99);

		// Menggabungkan nama pengguna dengan angka acak
    	$username = $namaPengguna . sprintf('%02d', $angkaAcak);

		// Output hasil username
    	return $username;
    }

    /**
     * Generate a random character.
     * @author Puji Ermanto <pujiermanto@gmail.com> 
     * @return string The generated random character.
     */
    public static function generateRandomChar() {
	  $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'; // Karakter yang tersedia
	  $randomChar = $chars[rand(0, strlen($chars) - 1)]; // Memilih karakter acak
	  return $randomChar;
	}

	 /**
     * Generate a random string of the specified length.
     * @author Puji Ermanto <pujiermanto@gmail.com>
     * @param int $length The length of the generated string.
     * @return string The generated random string.
     */
	public static function generateRandomString($length) {
		$result = '';
		for ($i = 0; $i < $length; $i++) {
	    	$result .= Helpers::generateRandomChar(); // Menambahkan karakter acak ke dalam string hasil
		}
		return $result;
	}

}


/*
Penjelasan:

    Class Helpers adalah sebuah class yang berisi berbagai fungsi bantu (helper functions) yang dapat digunakan dalam proyek PHP.
    Fungsi isMobileDevice() digunakan untuk memeriksa apakah pengguna sedang menggunakan perangkat mobile berdasarkan HTTP User Agent.
    Fungsi generate_token() digunakan untuk menghasilkan token acak.
    Fungsi generate_username() digunakan untuk menghasilkan username berdasarkan nama lengkap.
    Fungsi validatePhoneNumber() digunakan untuk memvalidasi nomor telepon.
    Fungsi formatPhoneNumber() digunakan untuk memformat nomor telepon.
    Fungsi formatPhoneEdit() digunakan untuk memformat nomor telepon dalam mode edit.
    Fungsi formatRupiah() digunakan untuk memformat angka menjadi format mata uang Rupiah.
    Fungsi generateUsernameFromName() digunakan untuk menghasilkan username dari nama.
    Fungsi generateRandomChar() digunakan untuk menghasilkan karakter acak.
    Fungsi generateRandomString() digunakan untuk menghasilkan string acak dengan panjang tertentu.
*/