### Bahan Skripsi Pemrogramman Web

> Dibuat dengan bahasa pemrogramman PHP versi 8.2, dengan mengusung konsep MVC sebagai alur utama programm ini.


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

> Silahkan upload terlebih dahulu file database yang tersedia di dalam direktori repository, file database dengan nama ```db_eoq.sql``` , akses database service yang biasa di gunakan, dalam kasus ini saya menggunakan phpmyadmin, kemudian buat database baru lalu import table baru dari file ```db_eoq.sql```.

> Selanjutnya setup file .env, buka kembali terminal akses direktori repository hasil clone, kemudian jalankan baris perintah berikut ini :

```bash
# cp .env.example .env
``` 

> Setelah file .env terbuat , buka file .env dan sesuaikan konfigurasi database dengan database yang telah di siapkan sebelumnya.

> Selanjutnya buka kembali web browser, masih mengarah ke url yang sama sebelumnya yaitu ```http://localhost:4041``` setelah web terbuka lihat di bagian hero web atau jumbotron atau bagian awal muka, ada tombol berwarna orange yang bertext ```Create User ->```  click tombol tersebut , maka akan dibuatkan struktur data baru untuk data user di table admin. Boleh cek ke phpmyadmin di table admin.

> Selanjutnya silahkan login untuk mengakses halaman dashboard.