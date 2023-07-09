$(document).ready(function() {
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
				loading.classList.remove('hidden')
				loading.classList.add('block')
				Logout()
			}
		})
	})
})