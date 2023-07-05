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

}