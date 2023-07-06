$(document).ready(function() {

	// Pagination displaying data consume
	$('#displaying').on('click', '.page-link', function(e) {
		e.preventDefault()
		const pageNum = $(this).data('num')

		getAllData(pagePath, pageNum)
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

	// add displaying data consume
	$('#displaying').on('click', '.add', function(e) {
		e.preventDefault()

		loadingBtn.removeClass('hidden')
		textBtn.addClass('hidden')

		const prepareData = {
			nm_lengkap: $('input[name="nm_lengkap"]').val(),
			alamat: $('textarea[name="alamat"]').val(),
			notlp: $('input[name="notlp"]').val(),
			role: $('#role').val()
		}

		const param = {
			data: prepareData
		}

		addData(param, 'data-user')
	})

	// edit data-user
	$('#displaying').on('click', '.edit', function() {
		const kd_data = $(this).attr('data-id')
		location.href=`/dashboard/${pagePath}/${kd_data}`
	})

	// Update displaying data consume
	$('#displaying').on('click', '.update', function(e) {
		e.preventDefault()

		loadingBtn.removeClass('hidden')
		textBtn.addClass('hidden')

		const prepareData = {
			kd_admin: $('input[name="kd_admin"]').val(),
			nm_lengkap: $('input[name="nm_lengkap"]').val(),
			alamat: $('textarea[name="alamat"]').val(),
			notlp: $('input[name="notlp"]').val(),
			username: $('input[name="username"]').val()
		}

		const param = {
			id: prepareData.kd_admin,
			data: prepareData
		}

		updateData(param, 'data-user')
	})

	// Delete user
	$('#displaying').on('click', '.delete', function() {
		
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
				const kd_admin = $(this).attr('data-id')
				const prepareData = {
					id: kd_admin,
					field: kd_admin
				}
				loading.classList.remove('hidden')
				loading.classList.add('block')
				deleteData(prepareData, 'data-user')
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
	})
})


getAllData(pagePath, 1)