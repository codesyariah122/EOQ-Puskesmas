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
		data: {
			username: data.username,
			password: data.password
		},
		success: function(response) {
			const userData = JSON.parse(response)

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

const updateData = (param, type) => {
	const alertEl = $('#alert')
	const messageSuccess = $('#message-success')
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
				username: param.data.username
			}
		break;

		default:
	}

	$.ajax({
		url: endPoint,
		type: 'POST',
		data: prepareData,
		startTime: new Date().getTime(),
		success: function(response) {
			const successData = JSON.parse(response)
			let time = (new Date().getTime() - this.startTime);
			
			if(successData.success) {

				console.log("This request took "+time+" ms");

				setTimeout(() => {
					alertEl.show();
					messageSuccess.html(`
						<span class="font-medium"> Update successfully!</span> ${successData.message}
					`)

					loadingBtn.addClass('hidden')
					textBtn.removeClass('hidden')
					Swal.fire({
						position: 'top-end',
						icon: 'success',
						title: successData.message,
						showConfirmButton: false,
						timer: 1500
					})
				}, 1000)
			}
		}
	})
}