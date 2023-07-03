$(document).ready(function() {
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


	$('#data-user').on('click', '.edit', function() {
		const kd_admin = $(this).attr('data-id')
		location.href=`/dashboard/data-user/${kd_admin}`
	})
})