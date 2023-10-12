/**
 * @author: Puji Ermanto <pujiermanto@gmail.com>
 * Desc: File ini merupakan serangkaian instruksi untuk melakukan manipulasi data dan element pada struktur html. Melakukan ajax request secara asynchronous, sehingga memungkinkan untuk menambahkan nilai visual pada user experience.
 * */


const formatIdr = (angka) => {
	const formatRupiah = new Intl.NumberFormat("id-ID", { style: "currency", currency: "IDR" }).format(angka);

	return formatRupiah

}

const formatDateIndonesia = (dateString) => {
  // Mendapatkan objek Date dari string tanggal
	const date = new Date(dateString);

  // Mendapatkan komponen tanggal, bulan, dan tahun
	const day = date.getDate();
  const month = date.getMonth() + 1; // Ditambahkan 1 karena bulan dimulai dari 0
  const year = date.getFullYear();

  // Mengatur format tanggal menjadi "DD-MM-YYYY"
  const formattedDate = `${day.toString().padStart(2, '0')}-${month.toString().padStart(2, '0')}-${year}`;

  return formattedDate;
}

const dateFormat = () => {
	const currentDate = new Date();
	const day = currentDate.getDate();
	const month = currentDate.toLocaleString('default', { month: 'short' });
	const year = currentDate.getFullYear();

	return `${day} ${month} ${year}`;
}

const hitungTotal = (data) => {
	const total = Math.round(data.harga * data.jumlah)
	return formatIdr(total)
}

const hitungEconomics = (data) => {
	return Math.round(Math.sqrt(2*(data.b_pesan * data.k_tahun) / data.b_simpan))
}

const hitungIntervalWaktu = (data) => {
	return Math.round(Math.sqrt((2 * data.b_pesan) / (data.b_simpan * data.k_tahun)) * 365)
}

const setUpPagination = (data) => {
	pagination.empty();
	paging.totalData=data.totalData
	paging.countPage=data.countPage
	paging.totalPage=data.totalPage
	paging.aktifPage=data.aktifPage

	const prevEl = document.createElement('li')
	const nextEl = document.createElement('li')
	prevEl.innerHTML = `
	<li><a href="#" class="page-link flex items-center justify-center px-3 h-8 ml-0 leading-tight border  rounded-l-lg  dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white ${paging.aktifPage > 1 ? 'bg-blue-50 border-blue-300 text-blue-600 cursor-pointer' : 'bg-white border-gray-300 text-gray-500 cursor-not-allowed' }" data-num="${paging.aktifPage > 1 ? paging.aktifPage - 1 : paging.aktifPage - 1}"><i class="fa-solid fa-angle-left"></i>&nbsp;Previous</a></li>
	`
	nextEl.innerHTML = `
	<li><a href="#" class="page-link flex items-center justify-center px-3 h-8 ml-0 leading-tight border  rounded-r-lg  dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white ${paging.aktifPage < paging.totalPage ? 'bg-blue-50 border-blue-300 text-blue-600 cursor-pointer' : 'bg-white border-gray-300 text-gray-500 cursor-not-allowed' }" data-num="${paging.aktifPage < paging.totalPage ? paging.aktifPage + 1 : paging.aktifPage + 1}">Next&nbsp;<i class="fa-solid fa-angle-right"></i></a></li>
	`

	pagination.append(prevEl)

	for (let i = 1; i <= paging.totalPage; i++) {
		let pageLink = $(`<li><a href="#" class="page-link flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white ${i == paging.aktifPage ? 'cursor-not-allowed' : 'cursor-pointer'}" data-num="${i}">${i}</a></li>`);
		if (i === paging.aktifPage) {
			pageLink.find('a').addClass('text-blue-600 border border-gray-300 bg-blue-50 hover:bg-blue-100 hover:text-blue-700 dark:border-gray-700 dark:bg-gray-700 dark:text-white');
		}
		pagination.append(pageLink);
	}

	pagination.append(nextEl)

}

const getAllData = (type, page=1, keyword='') => {
	const endPoint = `/lists/${type}?page=${page}${keyword ? '&keyword='+keyword : ''}`

	$.ajax({
		url: endPoint,
		type: 'GET',
		dataType: 'json',
		data: {},
		success: function (response) {

			let lists = response

			if(lists.success) {
				let domDataHTML = '';
				
				switch(type) {
				case 'data-user':
					const users = lists?.data
					const sessionUser = lists?.session_user

					users?.map(user => {
						domDataHTML += `
						<tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
						<th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
						${user.kd_admin}
						</th>
						<td class="px-6 py-4">
						${user.nm_lengkap}
						</td>
						<td class="px-6 py-4">
						${user.alamat}
						</td>
						<td class="px-6 py-4">
						${user.notlp}
						</td>
						<td class="px-6 py-4">
						${user.username}
						</td>
						<td class="px-6 py-4">
						<span class="bg-blue-100 text-blue-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-blue-400 border border-blue-400">${user.role}</span>
						</td>

						${user.username !== sessionUser ? 
						`<td>
						<div class="flex justify-center space-x-4">
						<div>
						<button type="button" class="edit px-3 py-2 text-xs font-medium text-center text-white bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 shadow-lg shadow-blue-500/50 dark:shadow-lg dark:shadow-blue-800/80 font-medium rounded-lg" data-id="${user.kd_admin}">
						<i class="fa-solid fa-pen-to-square"></i>
						</button>                                 
						</div>
						<div>
						<button type="button" class="delete px-3 py-2 text-xs font-medium text-center text-white text-white bg-gradient-to-r from-red-400 via-red-500 to-red-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 shadow-lg shadow-red-500/50 dark:shadow-lg dark:shadow-red-800/80 font-medium rounded-lg" data-id="${user.kd_admin}">
						<i class="fa-solid fa-trash"></i>
						</button>
						</div>
						</div>
						</td>` : 

						''
					}
					</tr>
					`;
				})
					break;
					
				case 'data-obat':
					const obats = lists.data

					obats.map(obat => {
						domDataHTML += `
						<tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
						<th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
						${obat.kd_obat}
						</th>
						<td class="px-6 py-4">
						${obat.nm_obat}
						</td>
						<td class="px-6 py-4">
						<span class="bg-blue-100 text-blue-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-blue-400 border border-blue-400">${obat.jenis_obat}</span>
						</td>
						<td class="px-6 py-4">
						${formatIdr(obat.harga)}
						</td>
						<td class="px-6 py-4">
						${obat.stok}
						</td>
						<td>
						<div class="flex justify-center space-x-4">
						<div>
						<button type="button" class="edit px-3 py-2 text-xs font-medium text-center text-white bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 shadow-lg shadow-blue-500/50 dark:shadow-lg dark:shadow-blue-800/80 font-medium rounded-lg" data-id="${obat.kd_obat}">
						<i class="fa-solid fa-pen-to-square"></i>
						</button>                                 
						</div>
						<div>
						<button type="button" class="delete px-3 py-2 text-xs font-medium text-center text-white text-white bg-gradient-to-r from-red-400 via-red-500 to-red-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 shadow-lg shadow-red-500/50 dark:shadow-lg dark:shadow-red-800/80 font-medium rounded-lg" data-id="${obat.kd_obat}">
						<i class="fa-solid fa-trash"></i>
						</button>
						</div>
						</div>
						</td>
						</tr>
						`;
					})
					break;

				case "laporan-eoq":
					const reports = lists.data
					reports.map(report => {
						domDataHTML += `
						<tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
						<td>
						<div class="flex justify-center space-x-4">
						<div>
						<input class="default-checkbox dataCheckbox" type="checkbox" value="${report.kd_obat}" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">                                
						</div>
						</div>
						</td>
						<td class="field-id hidden" data-id="${report.id}">
						${report.id}
						</td>
						<th scope="row" class="px-6 py-4 text-xs font-medium text-gray-900 whitespace-nowrap dark:text-white">
						${report.kd_obat}
						</th>
						<td class="px-6 py-4">
						${report.nm_obat}
						</td>
						<td class="px-6 py-4">${report.k_tahun}</td>
						<td class="px-6 py-4">
						${formatIdr(report.b_simpan)}
						</td>
						<td class="px-6 py-4">
						${formatIdr(report.b_pesan)}
						</td>
						<td class="px-6 py-4">
						<span class="bg-blue-100 text-blue-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-blue-400 border border-blue-400">
						${hitungEconomics({
							b_pesan: report.b_pesan,
							k_tahun: report.k_tahun,
							b_simpan: report.b_simpan
						})
					} ${report.jenis_obat}
					</span>
					</td>
					<td class="px-6 py-4">
					<span class="bg-green-100 text-green-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-green-400 border border-green-400">
					${hitungIntervalWaktu({
						b_pesan: report.b_pesan,
						k_tahun: report.k_tahun,
						b_simpan: report.b_simpan
					})
				} Hari
				</span>
				</td>
				</tr>
				`;})
					break;

				case "laporan-pembelian":
					const reportsbeli = lists.data
					reportsbeli.map(report => {
						domDataHTML += `
						<tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
						<td>
						<div class="flex justify-center space-x-4">
						<div>
						<input class="default-checkbox dataCheckbox" type="checkbox" value="${report.kd_obat}" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">                                
						</div>
						</div>
						</td>
						<td class="field-id hidden" data-id="${report.id}">
						${report.id}
						</td>
						<th scope="row" class="px-6 py-4 text-xs font-medium text-gray-900 whitespace-nowrap dark:text-white">

						<div class="kd_beli">${report.kd_beli}</div>
						<button type="button" class="copyButton text-gray-700 border-none hover:bg-gray-600 hover:text-white focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-lg p-2.5 text-center inline-flex items-center mr-2 dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:focus:ring-blue-800 dark:hover:bg-blue-500" data-kode="${report.kd_beli}">
						<i class="fa-solid fa-clipboard"></i>
						<span class="sr-only">Icon description</span>
						</button>
						</th>
						<td class="px-6 py-4">
						${formatDateIndonesia(report.tgl_beli)}
						</td>
						<td class="px-6 py-4">${report.kd_obat}</td>
						<td class="px-6 py-4">${report.nm_obat}</td>
						<td class="px-6 py-4">${report.jumlah}</td>
						<td class="px-6 py-4">
						${formatIdr(report.harga)}
						</td>
						<td class="px-6 py-4">
						${hitungTotal({harga: report.harga, jumlah: report.jumlah})}
						</td>

						</tr>
						`;})
					break;

				case "pembelian":
					const listsBeli = lists.data
					listsBeli.map(report => {
						domDataHTML += `
						<tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
						<td class="field-id hidden" data-id="${report.id}">
						${report.id}
						</td>
						<th scope="row" class="px-6 py-4 text-xs font-medium text-gray-900 whitespace-nowrap dark:text-white">

						<div class="kd_beli">${report.kd_beli}</div>
						<button type="button" class="copyButton text-gray-700 border-none hover:bg-gray-600 hover:text-white focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-lg p-2.5 text-center inline-flex items-center mr-2 dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:focus:ring-blue-800 dark:hover:bg-blue-500" data-kode="${report.kd_beli}">
						<i class="fa-solid fa-clipboard"></i>
						<span class="sr-only">Icon description</span>
						</button>
						</th>
						<td class="px-6 py-4">
						${formatDateIndonesia(report.tgl_beli)}
						</td>
						<td class="px-6 py-4">${report.kd_obat}</td>
						<td class="px-6 py-4">${report.nm_obat}</td>
						<td class="px-6 py-4">${report.jumlah}</td>
						<td class="px-6 py-4">
						${formatIdr(report.harga)}
						</td>
						<td class="px-6 py-4">
						${hitungTotal({harga: report.harga, jumlah: report.jumlah})}
						</td>
						<td>
						<div class="flex justify-center space-x-4">
						<div>
						<button type="button" class="edit px-3 py-2 text-xs font-medium text-center text-white bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 shadow-lg shadow-blue-500/50 dark:shadow-lg dark:shadow-blue-800/80 font-medium rounded-lg" data-id="${report.kd_beli}">
						<i class="fa-solid fa-pen-to-square"></i>
						</button>                                 
						</div>
						<div>
						<button type="button" class="delete px-3 py-2 text-xs font-medium text-center text-white text-white bg-gradient-to-r from-red-400 via-red-500 to-red-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 shadow-lg shadow-red-500/50 dark:shadow-lg dark:shadow-red-800/80 font-medium rounded-lg" data-id="${report.kd_beli}">
						<i class="fa-solid fa-trash"></i>
						</button>
						</div>
						</div>
						</td>
						</tr>
						`;})
					break;
					// type lainnya ....

				default:

				}
				
				// Append data to element dom
				domDataLists.html(domDataHTML)

				// pagination
				setUpPagination(lists)
			} else {
				domDataLists.html('')
			}
		}
	})
}

const searchData = (param, type) => {
	let endPoint = ''
	let prepareData = {}

	switch(type) {
	case 'data-user':
		endPoint = `/lists/${type}?keyword=${param.data}`
		prepareData = {
			keyword: param.data
		}
		break;
	case 'data-obat':
		endPoint = `/lists/${type}?keyword=${param.data}`
		prepareData = {
			keyword: param.data
		}
		break;

	case "laporan-eoq":
		endPoint = `/lists/${type}?keyword=${param.data}`
		prepareData = {
			keyword: param.data
		}
		break;

	case "laporan-pembelian":
		endPoint = `/lists/${type}?keyword=${param.data}`
		prepareData = {
			keyword: param.data
		}
		break;

	case "pembelian":
		endPoint = `/lists/${type}?keyword=${param.data}`
		prepareData = {
			keyword: param.data
		}
		break;
			// type lainnya ...

	default:
	}

	$.ajax({
		url: endPoint,
		type: 'GET',
		dataType: 'json',
		startTime: new Date().getTime(),
		success: function(response) {
			let lists = response

			let domDataHTML = '';
			
			if(lists.success) {
				
				switch(type) {
				case 'data-user':
					const users = lists?.data
					const sessionUser = lists?.session_user

					users?.map(user => {
						domDataHTML += `
						<tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
						<th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
						${user.kd_admin}
						</th>
						<td class="px-6 py-4">
						${user.nm_lengkap}
						</td>
						<td class="px-6 py-4">
						${user.alamat}
						</td>
						<td class="px-6 py-4">
						${user.notlp}
						</td>
						<td class="px-6 py-4">
						${user.username}
						</td>

						${user.username !== sessionUser ? 
						`<td>
						<div class="flex justify-center space-x-4">
						<div>
						<button type="button" class="edit px-3 py-2 text-xs font-medium text-center text-white bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 shadow-lg shadow-blue-500/50 dark:shadow-lg dark:shadow-blue-800/80 font-medium rounded-lg" data-id="${user.kd_admin}">
						<i class="fa-solid fa-pen-to-square"></i>
						</button>                                 
						</div>
						<div>
						<button type="button" class="delete px-3 py-2 text-xs font-medium text-center text-white text-white bg-gradient-to-r from-red-400 via-red-500 to-red-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 shadow-lg shadow-red-500/50 dark:shadow-lg dark:shadow-red-800/80 font-medium rounded-lg" data-id="${user.kd_admin}">
						<i class="fa-solid fa-trash"></i>
						</button>
						</div>
						</div>
						</td>` : 

						''
					}
					</tr>
					`;
				})
					break;
					
				case 'data-obat':
					const obats = lists.data
					obats.map(obat => {
						domDataHTML += `
						<tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
						<th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
						${obat.kd_obat}
						</th>
						<td class="px-6 py-4">
						${obat.nm_obat}
						</td>
						<td class="px-6 py-4">
						<span class="bg-blue-100 text-blue-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-blue-400 border border-blue-400">${obat.jenis_obat}</span>
						</td>
						<td class="px-6 py-4">
						${formatIdr(obat.harga)}
						</td>
						<td class="px-6 py-4">
						${obat.stok}
						</td>
						<td>
						<div class="flex justify-center space-x-4">
						<div>
						<button type="button" class="edit px-3 py-2 text-xs font-medium text-center text-white bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 shadow-lg shadow-blue-500/50 dark:shadow-lg dark:shadow-blue-800/80 font-medium rounded-lg" data-id="${obat.kd_obat}">
						<i class="fa-solid fa-pen-to-square"></i>
						</button>                                 
						</div>
						<div>
						<button type="button" class="delete px-3 py-2 text-xs font-medium text-center text-white text-white bg-gradient-to-r from-red-400 via-red-500 to-red-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 shadow-lg shadow-red-500/50 dark:shadow-lg dark:shadow-red-800/80 font-medium rounded-lg" data-id="${obat.kd_obat}">
						<i class="fa-solid fa-trash"></i>
						</button>
						</div>
						</div>
						</td>
						</tr>
						`;
					})
					break;

				case "laporan-eoq":
					const reports = lists.data
					reports.map(report => {
						domDataHTML += `
						<tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
						<td>
						<div class="flex justify-center space-x-4">
						<div>
						<input id="default-checkbox" type="checkbox" value="${report.kd_obat}" class="dataCheckbox w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">                                
						</div>
						</div>
						</td>
						<th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
						${report.kd_obat}
						</th>
						<td class="px-6 py-4">
						${report.nm_obat}
						</td>
						<td class="px-6 py-4">${report.k_tahun}</td>
						<td class="px-6 py-4">
						${formatIdr(report.b_simpan)}
						</td>
						<td class="px-6 py-4">
						${formatIdr(report.b_pesan)}
						</td>
						<td class="px-6 py-4">
						<span class="bg-blue-100 text-blue-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-blue-400 border border-blue-400">
						${hitungEconomics({
							b_pesan: report.b_pesan,
							k_tahun: report.k_tahun,
							b_simpan: report.b_simpan
						})
					} ${report.jenis_obat}
					</span>
					</td>
					<td class="px-6 py-4">
					<span class="bg-green-100 text-green-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-green-400 border border-green-400">
					${hitungIntervalWaktu({
						b_pesan: report.b_pesan,
						k_tahun: report.k_tahun,
						b_simpan: report.b_simpan
					})
				} Hari
				</span>
				</td>
				</tr>
				`;
			})
					break;

				case "laporan-pembelian":
					const reportsbeli = lists.data
					reportsbeli.map(report => {
						domDataHTML += `
						<tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
						<td>
						<div class="flex justify-center space-x-4">
						<div>
						<input class="default-checkbox dataCheckbox" type="checkbox" value="${report.kd_obat}" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">                                
						</div>
						</div>
						</td>
						<td class="field-id hidden" data-id="${report.id}">
						${report.id}
						</td>
						<th scope="row" class="px-6 py-4 text-xs font-medium text-gray-900 whitespace-nowrap dark:text-white">

						<div class="kd_beli">${report.kd_beli}</div>
						<button type="button" class="copyButton text-gray-700 border-none hover:bg-gray-600 hover:text-white focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-lg p-2.5 text-center inline-flex items-center mr-2 dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:focus:ring-blue-800 dark:hover:bg-blue-500" data-kode="${report.kd_beli}">
						<i class="fa-solid fa-clipboard"></i>
						<span class="sr-only">Icon description</span>
						</button>
						</th>
						<td class="px-6 py-4">
						${formatDateIndonesia(report.tgl_beli)}
						</td>
						<td class="px-6 py-4">${report.kd_obat}</td>
						<td class="px-6 py-4">${report.nm_obat}</td>
						<td class="px-6 py-4">${report.jumlah}</td>
						<td class="px-6 py-4">
						${formatIdr(report.harga)}
						</td>
						<td class="px-6 py-4">
						${hitungTotal({harga: report.harga, jumlah: report.jumlah})}
						</td>

						</tr>
						`;})
					break;

				case "pembelian":
					const listsBeli = lists.data
					listsBeli.map(report => {

						domDataHTML += `
						<tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
						<td class="field-id hidden" data-id="${report.id}">
						${report.id}
						</td>
						<th scope="row" class="px-6 py-4 text-xs font-medium text-gray-900 whitespace-nowrap dark:text-white">

						<div class="kd_beli">${report.kd_beli}</div>
						<button type="button" class="copyButton text-gray-700 border-none hover:bg-gray-600 hover:text-white focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-lg p-2.5 text-center inline-flex items-center mr-2 dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:focus:ring-blue-800 dark:hover:bg-blue-500" data-kode="${report.kd_beli}">
						<i class="fa-solid fa-clipboard"></i>
						<span class="sr-only">Icon description</span>
						</button>
						</th>
						<td class="px-6 py-4">
						${formatDateIndonesia(report.tgl_beli)}
						</td>
						<td class="px-6 py-4">${report.kd_obat}</td>
						<td class="px-6 py-4">${report.nm_obat}</td>
						<td class="px-6 py-4">${report.jumlah}</td>
						<td class="px-6 py-4">
						${formatIdr(report.harga)}
						</td>
						<td class="px-6 py-4">
						${hitungTotal({harga: report.harga, jumlah: report.jumlah})}
						</td>
						<td>
						<div class="flex justify-center space-x-4">
						<div>
						<button type="button" class="edit px-3 py-2 text-xs font-medium text-center text-white bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 shadow-lg shadow-blue-500/50 dark:shadow-lg dark:shadow-blue-800/80 font-medium rounded-lg" data-id="${report.kd_obat}">
						<i class="fa-solid fa-pen-to-square"></i>
						</button>                                 
						</div>
						<div>
						<button type="button" class="delete px-3 py-2 text-xs font-medium text-center text-white text-white bg-gradient-to-r from-red-400 via-red-500 to-red-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 shadow-lg shadow-red-500/50 dark:shadow-lg dark:shadow-red-800/80 font-medium rounded-lg" data-id="${report.kd_obat}">
						<i class="fa-solid fa-trash"></i>
						</button>
						</div>
						</div>
						</td>
						</tr>
						`;})
					break;
					// type lainnya ....

				default:

				}
				
				domDataLists.html(domDataHTML)

				setUpPagination(lists)
			} else {
				if(lists.empty) {
					domDataHTML += `
					<tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
					<th scope="row" colspan="2" class="text-center px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
					${lists.message}
					</th>
					</tr>
					`
					domDataLists.html(domDataHTML)
				}

			}
		}
	})

}


const addData = (param, type) => {
	let endPoint = `/add/${type}`
	let prepareData = {}

	switch(type) {
	case 'data-user':
		prepareData = {
			nm_lengkap: param.data.nm_lengkap,
			password: param.data.password,
			alamat: param.data.alamat,
			notlp: param.data.notlp,
			role: param.data.role
		}
		break;

	case 'data-obat':
		prepareData = {
			nm_obat: param.data.nm_obat,
			jenis_obat: param.data.jenis_obat,
			harga: param.data.harga,
			stok: param.data.stok
		}
		break;

	case "pengajuan-obat":
		prepareData = {
			kd_obat: param.data.kd_obat,
			k_tahun: param.data.k_tahun,
			b_simpan: param.data.b_simpan,
			b_pesan: param.data.b_pesan
		}
		break;

	case "pembelian":
		prepareData = {
			kd_obat: param.data.kd_obat,
			jumlah: param.data.jumlah
		}
		break;
			// type lainnya ...

	default:
	}

	$.ajax({
		url: endPoint,
		type: 'POST',
		dataType: 'json',
		data: prepareData,
		startTime: new Date().getTime(),
		success: function(response) {
			const responseData = response

			let time = (new Date().getTime() - this.startTime);
			
			if(responseData.error) {
				alertSuccess.hide()
				messageSuccess.html('')
				loadingBtn.addClass('hidden')
				textBtn.removeClass('hidden')
				alertError.show();
				messageError.html(`
					<span class="font-medium"> Ooops!</span>${responseData.message}!
					`)
				Swal.fire({
					icon: 'error',
					title: 'Oops...',
					text: responseData.message
				})
			}

			if(responseData.success) {
				alertError.hide()
				messageError.html('')
				console.log("This request took "+time+" ms");

				switch(type) {
				case 'data-user':
					$('input[name="nm_lengkap"]').val('')
					$('textarea[name="alamat"]').val('')
					$('input[name="notlp"]').val('')
					$('input[name="password"]').val('')
					$('#role').val('Pilih Role')
					setTimeout(() => {
						alertSuccess.show();
						messageSuccess.html(`
							<span class="font-medium"> Berhasil menambah pengguna baru!</span> ${responseData.message}
							`)

						loadingBtn.addClass('hidden')
						textBtn.removeClass('hidden')
						Swal.fire({
							position: 'top-end',
							icon: 'success',
							title: responseData.message,
							showConfirmButton: false,
							timer: 1500
						})

					}, 1000)
					break;

				case "data-obat":
					$('input[name="nm_obat"]').val('')
					$('#jenis_obat').val('Pilih Jenis Obat')
					$('input[name="harga"]').val('')
					$('input[name="stok"]').val('')
					setTimeout(() => {
						alertSuccess.show();
						messageSuccess.html(`
							<span class="font-medium"> Berhasil menambah data obat baru!</span> ${responseData.message}
							`)

						loadingBtn.addClass('hidden')
						textBtn.removeClass('hidden')
						Swal.fire({
							position: 'top-end',
							icon: 'success',
							title: responseData.message,
							showConfirmButton: false,
							timer: 1500
						})

					}, 1000)
					break;

				case "pengajuan-obat":
					kd_obatOption = null
					$('input[name="k_tahun"]').val('')
					$('input[name="b_simpan"]').val('')
					$('input[name="b_pesan"]').val('')
					$('#selectOption').val(null).trigger('change');
					setTimeout(() => {
						alertSuccess.show();
						messageSuccess.html(`
							<span class="font-medium"> Berhasil menambah data pengajuan obat baru!</span> ${responseData.message}
							&nbsp;<a href="/dashboard/laporan-eoq" class="text-white bg-gradient-to-r from-cyan-500 to-blue-500 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-cyan-300 dark:focus:ring-cyan-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2">
							Lihat data pengajuan
							</a>`)

						loadingBtn.addClass('hidden')
						textBtn.removeClass('hidden')
						Swal.fire({
							position: 'top-end',
							icon: 'success',
							title: responseData.message,
							showConfirmButton: false,
							timer: 1500
						})

					}, 1000)
					break;

				case "pembelian":
					kd_obatOption = ''
					$('input[name="jumlah"]').val('')
					setTimeout(() => {
						alertSuccess.show();
						messageSuccess.html(`
							<span class="font-medium"> Pembelian baru berhasil!</span> ${responseData.message}
							&nbsp;<a href="/dashboard/laporan-pembelian" class="text-white bg-gradient-to-r from-cyan-500 to-blue-500 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-cyan-300 dark:focus:ring-cyan-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2">
							Lihat laporan pembelian
							</a>`)
						kd_obatOption = null
						$('#selectOption').val(null).trigger('change');
						loadingBtn.addClass('hidden')
						textBtn.removeClass('hidden')
						Swal.fire({
							position: 'top-end',
							icon: 'success',
							title: responseData.message,
							showConfirmButton: false,
							timer: 1500
						})

					}, 1000)
					break;

					// type lainnya
				}
				if(pagePath !== 'pengajuan-obat') {
					getAllData(type, 1)
				}
			}
		}
	})
}

const updateData = (param, type) => {
	let endPoint = ''
	let prepareData = {}
	switch(type) {
	case 'data-user':
		endPoint = `/update/${type}/${param.id}`
		prepareData = {
			kd_admin: param.data.kd_admin,
			nm_lengkap: param.data.nm_lengkap,
			alamat: param.data.alamat,
			notlp: param.data.notlp,
			username: param.data.username,
			password: param.data.password,
			new_password: param.data.new_password
		}
		break;

	case 'data-obat':
		endPoint = `/update/${type}/${param.id}`
		prepareData = {
			kd_obat: param.data.kd_obat,
			nm_obat: param.data.nm_obat,
			jenis_obat: param.data.jenis_obat,
			harga: param.data.harga,
			stok: param.data.stok
		}
		break;

	case 'pembelian':
		endPoint = `/update/${type}/${param.id}`
		prepareData = {
			kd_beli: param.data.kd_beli,
			kd_obat: param.data.kd_obat,
			tgl_beli: param.data.tgl_beli,
			jumlah: param.data.jumlah
		}
		break;
		// type lainnya ....

	default:
	}

	$.ajax({
		url: endPoint,
		type: 'POST',
		dataType: 'json',
		data: prepareData,
		startTime: new Date().getTime(),
		success: function(response) {

			const responseData = response

			let time = (new Date().getTime() - this.startTime);

			if(responseData.error) {
				alertSuccess.hide()
				messageSuccess.html('')
				loadingBtn.addClass('hidden')
				textBtn.removeClass('hidden')
				alertError.show();
				messageError.html(`
					<span class="font-medium"> Ooops!</span>${responseData.message}!
					`)
				Swal.fire({
					icon: 'error',
					title: 'Oops...',
					text: responseData.message
				})
				loading.classList.remove('block')
				loading.classList.add('hidden')
			}

			if(responseData.success) {
				console.log("This request took "+time+" ms");

				setTimeout(() => {
					alertSuccess.show();
					messageSuccess.html(`
						<span class="font-medium"> Update successfully!</span> ${responseData.message}
						`)

					loadingBtn.addClass('hidden')
					textBtn.removeClass('hidden')
					loading.classList.remove('block')
					loading.classList.add('hidden')
					Swal.fire({
						position: 'top-end',
						icon: 'success',
						title: responseData.message,
						showConfirmButton: false,
						timer: 1500
					})

					history.go(-1)
				}, 1000)
			}
		}
	})
}

const deleteData = (param, type) => {
	
	let endPoint = `/delete/${type}/${param.id}`

	$.ajax({
		url: endPoint,
		type: 'DELETE',
		dataType: 'json',
		data: `${param.field}=${param.id}`,
		startTime: new Date().getTime(),
		success: function(response) {
			console.log(paging.aktifPage)
			const responseData = response
			
			let time = (new Date().getTime() - this.startTime);
			
			if(responseData.success) {
				console.log("This request took "+time+" ms");

				setTimeout(() => {
					loading.classList.remove('block')
					loading.classList.add('hidden')
					getAllData(type, paging.aktifPage)
					alertSuccess.show();
					messageSuccess.html(`
						<span class="font-medium"> Deleted successfully!</span> ${responseData.message}
						`)
					loadingBtn.addClass('hidden')
					textBtn.removeClass('hidden')
					Swal.fire({
						position: 'top-end',
						icon: 'success',
						title: responseData.message,
						showConfirmButton: false,
						timer: 1500
					})
				}, 1000)
			}
		}
	})
}

function showToast(message) {
	const toastContainer = document.getElementById('toastContainer');

  // Create toast element
	const toast = document.createElement('div');
	toast.classList.add('toast');
	toast.innerHTML = message;

  // Add toast to container
	toastContainer.appendChild(toast);

  // Show toast
	toast.classList.add('show');

  // Auto hide after 3 seconds
	setTimeout(() => {
		toast.classList.add('hide');
		setTimeout(() => {
      // Remove toast from container
			toastContainer.removeChild(toast);
		}, 300);
	}, 3000);
}


// function loadAndInitializeSelect2() {
// 	$.ajax({
// 		url: $('#selectOption').data('action'),
// 		dataType: 'json',
// 		delay: 100,
// 		processResults: function(data) {
// 			console.log(data)
// 			return {
// 				results: data
// 			};
// 		},
// 		success: function(data) {
// 			$('#selectOption').select2({
// 				placeholder: 'Pilih Obat',
// 				allowClear: true,
// 				data: data,
// 				cache: true
// 			});
// 		}
// 	});
// }

function loadAndInitializeSelect2() {
    $('#selectOption').select2({
        placeholder: 'Pilih Obat',
        allowClear: true,
        ajax: {
            url: $('#selectOption').data('action'),
            dataType: 'json',
            delay: 100,
            processResults: function(data) {
                return {
                    results: data
                };
            },
            cache: true
        },
        dropdownPosition: 'below' 
    });

    $.ajax({
        url: $('#selectOption').data('action'),
        dataType: 'json',
        success: function(data) {
            $('#selectOption').empty();
            $.each(data, function(index, item) {
                $('#selectOption').append(new Option(item.text, item.id, true, true));
            });

            $('#selectOption').trigger('change');
        }
    });
}
