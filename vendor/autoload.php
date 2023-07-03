<?php
/**
* @author : Puji Ermanto <pujiermanto@gmail.com>
* @return className
* @desc : File ini menjalankan built in function yang ada dalam package bahasa pemrogramman PHP khusus di versi 5 keatas
**/

// Fungsi ini akan dipanggil setiap kali memuat class yang belum didefinisikan
spl_autoload_register(function($className) {
    // Mengubah namespace menjadi path file dengan DIRECTORY_SEPARATOR
    $classPath = str_replace('\\', DIRECTORY_SEPARATOR, $className);
    
    // Menambahkan ekstensi file class
    $classFile = $classPath . '.php';
    
    // Memeriksa apakah file class ada
    if (file_exists($classFile)) {
        // Memuat file class
        require_once $classFile;
    }
});