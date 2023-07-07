/**
 * @author: Puji Ermanto <pujiermanto@gmail.com>
 * Desc: File ini menampung seluruh nilai variable agar serbaguna ketika di gunakan di bagian script lainnya.
 * */

// Run consume data
let url = new URL(window.location.href);
let path = url.pathname;
let pagePath = path.split('/')[2]

// Initialisasi variable
let loading = document.querySelector('#loading')
let alertSuccess = $('#alert-success')
let messageSuccess = $('#message-success')
let alertError = $('#alert-error')
let messageError = $('#message-error')
let loadingBtn = $('#loading-button')
let textBtn = $('#text-button')
let domDataLists = $(`#${pagePath}`)
let addUserModal = $('#addUserModal')
let pagination = $('#pagination')
let paging = {}
let kd_obatOption = null

// For pdf loaded
let selectedData = [];
let tableLaporan = $('#table-laporan')
let container = $('#tableContainer'),  
    cache_width = container.width(),  
    a4 = [610.28, 841.89];
let printLaporanBtn = $('#print-laporan')
let closeSelectedBtn = $('#close-selected')

setTimeout(() => {
	loading.classList.remove('block')
	loading.classList.add('hidden')
}, 1500)
