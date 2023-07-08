$(document).ready(function() {

	// Pagination displaying data consume
	$('#displaying').on('click', '.page-link', function(e) {
		e.preventDefault()
		const keyword = $('#search-data').val();
		const pageNum = $(this).data('num')

		if(keyword) {
			getAllData(pagePath, pageNum, keyword)
		} else {
			getAllData(pagePath, pageNum, keyword)
		}

	})

	// Search displaying data consume
	$('#displaying').on('keyup', '#search-data', function(e) {
		e.preventDefault()
		const keyword = e.target.value
		const param = {
			data: keyword
		}

		searchData(param, pagePath)

	})

	// Close pdf selected
	$('#displaying').on('click', '#close-selected', function(e) {
		e.preventDefault()
		tableLaporan.removeClass('hidden')
		tableLaporan.show().fadeIn(1000)
		container.hide('slow').fadeOut(1000)
		printLaporanBtn.show().fadeIn(1000)
		closeSelectedBtn.hide('slow').fadeOut(1000)
		closeSelectedBtn.addClass('hidden')
	})

	// add displaying data consume
	$('#displaying').on('click', '.add', function(e) {
		e.preventDefault()

		loadingBtn.removeClass('hidden')
		textBtn.addClass('hidden')

		let prepareData = {}

		switch(pagePath) {
		case 'data-user':
			prepareData = {
				nm_lengkap: $('input[name="nm_lengkap"]').val(),
				alamat: $('textarea[name="alamat"]').val(),
				notlp: $('input[name="notlp"]').val(),
				role: $('#role').val()
			}
			break;

		case 'data-obat':
			prepareData = {
				nm_obat: $('input[name="nm_obat"]').val(),
				jenis_obat: $('#jenis_obat').val(),
				harga: $('input[name="harga"]').val(),
				stok: $('input[name="stok"]').val()
			}
			break;

		case "pengajuan-obat":
			prepareData = {
				kd_obat: kd_obatOption,
				k_tahun: $('input[name="k_tahun"]').val(),
				b_simpan: $('input[name="b_simpan"]').val(),
				b_pesan: $('input[name="b_pesan"]').val()
			}
			break;

		default: 
			console.log("No type")
		}

		const param = {
			data: prepareData
		}

		addData(param, pagePath)
	})

	// Check checkbox displaying data laporan
	$('#displaying').on('change', '.selectAll', function(e) {
		e.preventDefault();
		container.show().fadeIn(1000)
		let isChecked = $(this).prop("checked");
		$(".dataCheckbox").prop("checked", isChecked);

	    // Perbarui status checkbox individu
		$(".dataCheckbox").each(function() {
			$(this).prop("checked", isChecked);
		});

	    // Panggil fungsi getDataFromTable untuk mengambil data dari tabel
	    getDataFromTable('checkAll'); // Panggil dengan selectType 'checkAll'
	});

	$('#displaying').on('change', '.dataCheckbox', function() {
		
		container.show().fadeIn(1000)

		if ($(".dataCheckbox:checked").length === $(".dataCheckbox").length) {
			$("#checkAll").prop("checked", true);
		} else {
			$("#checkAll").prop("checked", false);
		}
	    // Panggil fungsi getDataFromTable untuk mengambil data dari tabel
	    getDataFromTable('checkIndividual'); // Panggil dengan selectType 'checkIndividual'
	});


	// edit data-user
	$('#displaying').on('click', '.edit', function() {
		const kd_data = $(this).attr('data-id')
		location.href=`/dashboard/${pagePath}/${kd_data}`
	})

	// Update displaying data consume
	$('#displaying').on('click', '.update', function(e) {
		e.preventDefault()
		loading.classList.remove('hidden')
		loading.classList.add('block')
		loadingBtn.removeClass('hidden')
		textBtn.addClass('hidden')
		let prepareData={}
		let id = null

		switch(pagePath) {
		case 'data-user':
			prepareData = {
				kd_admin: $('input[name="kd_admin"]').val(),
				nm_lengkap: $('input[name="nm_lengkap"]').val(),
				alamat: $('textarea[name="alamat"]').val(),
				notlp: $('input[name="notlp"]').val(),
				username: $('input[name="username"]').val()
			}
			id = prepareData.kd_admin
			break;

		case 'data-obat':
			prepareData = {
				kd_obat: $('input[name="kd_obat"]').val(),
				nm_obat: $('input[name="nm_obat"]').val(),
				jenis_obat: $('#jenis_obat').val(),
				harga: $('input[name="harga"]').val(),
				stok: $('input[name="stok"]').val()
			}
			id = prepareData.kd_obat
			break;

		default:
			console.log("No type")
		}

		const param = {
			id: id,
			data: prepareData
		}

		updateData(param, pagePath)
	})

	// Delete user
	$('#displaying').on('click', '.delete', function() {
		let prepareData = {}

		Swal.fire({
			title: 'Are you sure?',
			text: "You won't be able to revert this!",
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Yes, delete it!'
		}).then((result) => {
			if (result.isConfirmed) {
				switch(pagePath) {
				case 'data-user':
					let kd_admin = $(this).attr('data-id')
					prepareData = {
						id: kd_admin,
						field: kd_admin
					}
					break;

				case 'data-obat':
					let kd_obat = $(this).attr('data-id')
					prepareData = {
						id: kd_obat,
						field: kd_obat
					}
					break;
				}

				loading.classList.remove('hidden')
				loading.classList.add('block')

				deleteData(prepareData, pagePath)
			}
		})
	})

	// Close modal & clear data input value
	$('#addModal').on('click', '.close-modal', function(e) {
		e.preventDefault()
		$('input[name="kd_admin"]').val('')
		$('input[name="nm_lengkap"]').val('')
		$('textarea[name="alamat"]').val('')
		$('input[name="notlp"]').val('')
		$('input[name="username"]').val('')
		alertError.hide()
		messageError.html('')
		loadingBtn.addClass('hidden')
		textBtn.removeClass('hidden')
	})


	// option select lists obat from select2
	$('#selectOption').select2({
		placeholder: 'Pilih Obat',
		allowClear: true,
		minimumInputLength: 3, // Jumlah karakter minimal untuk memulai pencarian
		ajax: {
			url: $('#selectOption').data('action'), // Mendapatkan URL endpoint dari atribut data-action
			dataType: 'json',
			delay: 100,
			processResults: function(data) {
				return {
					results: data
				};
			},
			cache: true
		}
	}).on('select2:select', function(e) {
	    let selectedValue = e.params.data.id; // Mendapatkan nilai (value) opsi terpilih
	    kd_obatOption = selectedValue
	});


})


getAllData(pagePath, 1)