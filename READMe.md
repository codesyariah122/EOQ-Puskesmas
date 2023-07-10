### Bahan Skripsi Pemrogramman Web

### Print laporan ke PDF
https://github.com/codesyariah122/skripsi/assets/13291805/a4d19210-f917-4445-a1aa-2a971b3ec90a

### User password updating
https://github.com/codesyariah122/skripsi/assets/13291805/4122da09-07db-4f8e-add1-d1d3da659927

### Tambah pembelian && Mengurangi jumlah stok
https://github.com/codesyariah122/skripsi/assets/13291805/80fed98b-1bea-4985-9945-e063f1d0d7db

https://github.com/codesyariah122/skripsi/assets/13291805/809848ba-43e7-43ac-b202-4857fa4c09dc

https://github.com/codesyariah122/skripsi/assets/13291805/16b52bf8-0ab5-409f-b80a-e00810d719b3


> Dibuat dengan bahasa pemrogramman PHP versi 8.2, dengan mengusung konsep MVC sebagai alur utama programm ini.

### Tech Stack  
1. PHP Native with mvc concept (PHP 8.2)
2. PHP::PDO Extention for database cumunication
3. MariaDB database server
4. Javascript, JQuery, Select2 , JQuery.Ajax, Sweetalert
5. Tailwindcss with plugins flowbite

Link documentasi
1. select2 = https://select2.org/searching
2. sweetalert = https://sweetalert2.github.io/
3. flowbite tailwind plugins = https://flowbite.com/docs/getting-started/quickstart/
3. tailwindcss = https://tailwindcss.com/docs/installation
4. fontawesome = https://fontawesome.com/search?o=r&m=free
5. PHP :: PDO =
    - https://www.php.net/manual/en/book.pdo.php
    - https://www.phptutorial.net/php-pdo/
6. Javascript = https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Functions


##### Run in dev
> Clone repository ini terlebih dahulu, selanjutnya akses melalui terminal / cmd(di windows), buka terminal dan akses direktori hasil clone repository ini kemudian jalankan baris perintah dibawah ini.  

```bash
# chmod +x server.sh
# ./server.sh
```  

> Selanjutnya setelah server running dengan informasi seperti ini :  

```bash
# [Mon Jul  3 23:34:34 2023] PHP 8.2.7 Development Server (http://localhost:4041) started
```  

> Silahkan buka web browser : Firefox, google chrome atau yang lainnya. akses url sesuai dengan informasi running server yang terdapat di layar terminal / cmd(di windows), yaitu ```http://localhost:4041```. Jika terdapat error seperti ini :

***
![db_error](https://github.com/codesyariah122/skripsi/assets/13291805/0cd005de-2db2-4eab-aacf-99225d1725a7)

***  

> Silahkan import terlebih dahulu file database yang tersedia di dalam direktori repository, file database dengan nama ```db_eoq.sql``` , akses database service yang biasa di gunakan, dalam kasus ini saya menggunakan phpmyadmin, kemudian buat database baru lalu import table baru dari file ```db_eoq.sql```.

> Selanjutnya setup file .env, buka kembali terminal akses direktori repository hasil clone, kemudian jalankan baris perintah berikut ini :

```bash
# cp .env.example .env
``` 

> Setelah file .env terbuat , buka file .env dan sesuaikan konfigurasi database dengan database yang telah di siapkan sebelumnya.

> Selanjutnya buka kembali web browser, masih mengarah ke url yang sama sebelumnya yaitu ```http://localhost:4041``` setelah web terbuka lihat di bagian hero web atau jumbotron atau bagian awal muka, ada tombol berwarna orange yang bertext ```Create User ->```  click tombol tersebut , maka akan dibuatkan struktur data baru untuk data user di table admin. Boleh cek ke phpmyadmin di table admin.

> Selanjutnya silahkan login untuk mengakses halaman dashboard.
