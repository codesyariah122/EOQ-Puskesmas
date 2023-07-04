$(document).ready(function() {

	getAllData('data-user')

	// Login dashboard
	$('#login-page').on('click', '#login', function(e) {
		
		e.preventDefault();

		loadingBtn.removeClass('hidden')
		textBtn.addClass('hidden')
		/**
		 * @login function
		 * method login dari file function.js
		 * */
		const data = {
			username: $('#username').val(),
			password: $('#password').val()
		}

		Login(data)
	})

	// Logout dashboard
	$('#navbar').on('click', '.logout', function(e){
		e.preventDefault()

		Swal.fire({
			title: 'Are you sure?',
			text: "You won't be able to revert this!",
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Yes, logout!'
		}).then((result) => {
			if (result.isConfirmed) {
				Logout()
			}
		})
	})

	// add data-user
	$('#data-user').on('click', '.add', function(e) {
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
	$('#data-user').on('click', '.edit', function() {
		const kd_admin = $(this).attr('data-id')
		location.href=`/dashboard/data-user/${kd_admin}`
	})

	// Update data user
	$('#data-user').on('click', '.update', function(e) {
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
	$('#data-user').on('click', '.delete', function() {
		
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
				deleteData(prepareData, 'data-user')
			}
		})
	})
})