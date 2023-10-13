/**
 * @author: Puji Ermanto <pujiermanto@gmail.com>
 * Desc: File ini menampung seluruh nilai variable agar serbaguna ketika di gunakan di bagian script lainnya.
 * */

// Run consume data
let url = new URL(window.location.href),
path = url.pathname,
pagePath = path.split('/')[2]

// Initialisasi variable
let loginTime;
let loading = document.querySelector('#loading')
let alertSuccess = $('#alert-success')
let messageSuccess = $('#message-success')
let alertError = $('#alert-error')
let messageError = $('#message-error')
let loadingBtn = $('#loading-button')
let textBtn = $('#text-button')
let domDataLists = $(`#${pagePath}`)
let domLogBeli = $('#log-beli')
let addUserModal = $('#addUserModal')
let pagination = $('#pagination')
let paging = {}
let kd_obatOption = null

// For pdf loaded
let selectedData = []
let tableLaporan = $('#table-laporan')
let container = $('#tableContainer')
let cache_width = container.width()
let a4 = [600.28, 841.89]
let printLaporanBtn = $('#print-laporan')
let closeSelectedBtn = $('#close-selected')
let select2Elem = $('.select2-results').data('select2')

setTimeout(() => {
	loading.classList.remove('block')
	loading.classList.add('hidden')
}, 1500)


function countdownTimer(timestamp) {
  	// Mendapatkan elemen HTML untuk menampilkan countdown time
	const countdownElement = document.getElementById('login-time');

  	// Mengupdate tampilan countdown time setiap detik
	const countdownInterval = setInterval(() => {
    	// Mendapatkan tanggal sekarang
		const now = Math.floor(Date.now() / 1000);

    	// Menghitung selisih waktu antara timestamp dan tanggal sekarang
		const difference = Math.abs(timestamp - now);

    	// Menghitung jumlah hari, jam, menit, dan detik
		const days = Math.floor(difference / (24 * 60 * 60));
		const hours = Math.floor((difference % (24 * 60 * 60)) / 3600);
		const minutes = Math.floor((difference % 3600) / 60);
		const seconds = difference % 60;

    	// Memperbarui tampilan countdown time
		countdownElement.innerHTML = `<i class="fas fa-business-time"></i> &nbsp;Sesi login: ${minutes} menit ${seconds} detik`;
    	// Memeriksa apakah waktu countdown telah berakhir
		if (difference <= 0) {
			clearInterval(countdownInterval);
			countdownElement.textContent = "Sesi Login Habis";
			location.replace="/logout"
		}
  }, 1000); // Set interval 1 detik (1000 milidetik)
}

countdownTimer(expired_login ? expired_login : null)