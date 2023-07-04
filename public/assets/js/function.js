let saveLogin = (data, key) => {
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


const Logout = () => {
	loading.classList.add('block')
	$.ajax({
		url: '/logout',
		type: 'POST',
		data: {},
		success: function(response) {
			const userData = JSON.parse(response)
			if(userData.success) {
				setTimeout(() => {
					loading.classList.remove('block')
					
					saveLogin(userData.data.token, 'token')

					Swal.fire({
						position: 'top-end',
						icon: 'success',
						title: userData.message,
						showConfirmButton: false,
						timer: 1500
					})
					window.location.replace(`/?logut=user_logout`)
				}, 1500)
			}
		}
	})
}