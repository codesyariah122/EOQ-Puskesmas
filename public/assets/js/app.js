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


	$('#data-user').on('click', '#edit', function() {
		console.log("Hallo Edit User")
	})
})