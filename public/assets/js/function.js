const saveLogin = (data, key) => {
	localStorage.setItem(key, JSON.stringify(data))
}

const Login = (data) => {
	$.ajax({
		url: '/auth-login',
		type: 'POST',
		data: {
			username: data.username,
			password: data.password
		},
		success: function(response) {
			const userData = JSON.parse(response)
			if(userData.success) {
				setTimeout(() => {
					loadingBtn.addClass('hidden')
					textBtn.removeClass('hidden')
					
					saveLogin(userData.data.token, 'token')

					Swal.fire({
						position: 'top-end',
						icon: 'success',
						title: userData.message,
						showConfirmButton: false,
						timer: 1500
					})
					window.location.replace(`/dashboard/${userData.data.username}`)
				}, 1500)
			}
		}
	})
}