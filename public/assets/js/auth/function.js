/**
 * @author: Puji Ermanto <pujiermanto@gmail.com>
 * Desc: File ini merupakan serangkaian instruksi untuk melakukan manipulasi data dan element pada struktur html. Melakukan ajax request secara asynchronous, sehingga memungkinkan untuk menambahkan nilai visual pada user experience.
 * */


let saveLogin = (data, key) => {
	localStorage.setItem(key, JSON.stringify(data))
}

let removeLogin = (key) => {
	localStorage.removeItem(key)
}


const Login = (data) => {
	$.ajax({
		url: '/auth-login',
		type: 'POST',
		dataType: 'json',
		data: {
			username: data.username,
			password: data.password
		},
		success: function(response) {
			const userData = response
			if(userData.error) {
				Swal.fire({
					icon: 'error',
					title: 'Oops...',
					text: userData.message
				})
				loadingBtn.addClass('hidden')
				textBtn.removeClass('hidden')
			}

			if(userData.success) {
				setTimeout(() => {
					loadingBtn.addClass('hidden')
					textBtn.removeClass('hidden')
					
					saveLogin({token: userData.data.token, role: userData.data.role}, 'token')

					Swal.fire({
						position: 'top-end',
						icon: 'success',
						title: userData.message,
						showConfirmButton: false,
						timer: 1500
					})
					window.location.replace(`/dashboard/${userData.data.role}`)
				}, 1000)
			}
		}
	})
}

const Logout = () => {
	loading.classList.add('block')
	$.ajax({
		url: '/logout',
		type: 'POST',
		dataType: 'json',
		data: {},
		success: function(response) {
			const userData = response
			if(userData.success) {
				setTimeout(() => {
					loading.classList.remove('block')
					loading.classList.add('hidden')
					
					removeLogin('token')

					Swal.fire({
						position: 'top-end',
						icon: 'success',
						title: userData.message,
						showConfirmButton: false,
						timer: 1500
					})
					window.location.replace(`/?logut=user_logout`)
				}, 1000)
			}
		}
	})
}