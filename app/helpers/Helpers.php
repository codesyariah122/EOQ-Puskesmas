<?php
/**
 * @author Puji Ermanto <pujiermanto@gmail.com>
 * @return USER_AGENT
**/

namespace app\helpers;


class Helpers {

	public function __construct()
	{
		
	}

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

	
	public function format_wa_send($data)
	{
		$mobil = $data['category'] !== 'Paket City Tour' ? "Mobil: " . $data['title']. ",\n" : '' ;

		$text = "Hello, D&N Tour. Saya ingin " . ($data['category'] === 'Sewa Mobil' ? $data['category'] : 'memesan') . " " . ($data['category'] !== 'Sewa Mobil' ? 'paket' : '') . " dari D&N Tour, berikut rincian pesanan saya:\n"
		. "Category: " . $data['category'] . ",\n"
		. $mobil
		. "Price: " . $data['price'];

		return str_replace(' ', '+', urlencode($text));
	}

	public function generate_token() 
	{
	    $length = 32; // Panjang token dalam byte
	    $token = bin2hex(random_bytes($length)); // Menggunakan random_bytes() untuk menghasilkan token acak
	    return $token;
	}

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

}