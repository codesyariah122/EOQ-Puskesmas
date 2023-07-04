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

const getAllData = (type) => {
	const endPoint = `/lists/${type}`
	$.ajax({
		url: endPoint,
		type: 'GET',
		dataType: 'json',
		data: {},
		success: function (response) {
			let lists = response
			if(lists.success) {
				let domDataHTML = '';
				
				switch(type) {
				case 'data-user':
					const users = lists?.data
					const sessionUser = lists?.session_user

					users?.map(user => {
						domDataHTML += `
						<tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
						<th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
						${user.kd_admin}
						</th>
						<td class="px-6 py-4">
						${user.nm_lengkap}
						</td>
						<td class="px-6 py-4">
						${user.alamat}
						</td>
						<td class="px-6 py-4">
						${user.notlp}
						</td>
						<td class="px-6 py-4">
						${user.username}
						</td>

						${user.username !== sessionUser ? 
						`<td>
						<div class="flex justify-center space-x-4">
						<div>
						<button type="button" class="edit px-3 py-2 text-xs font-medium text-center text-white bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 shadow-lg shadow-blue-500/50 dark:shadow-lg dark:shadow-blue-800/80 font-medium rounded-lg" data-id="${user.kd_admin}">
						<i class="fa-solid fa-pen-to-square"></i>
						</button>                                 
						</div>
						<div>
						<button type="button" class="delete px-3 py-2 text-xs font-medium text-center text-white text-white bg-gradient-to-r from-red-400 via-red-500 to-red-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 shadow-lg shadow-red-500/50 dark:shadow-lg dark:shadow-red-800/80 font-medium rounded-lg" data-id="${user.kd_admin}">
						<i class="fa-solid fa-trash"></i>
						</button>
						</div>
						</div>
						</td>` : 

						''
					}
					</tr>
					`;
				})
					break;
					// type lainnya ....

				default:

				}
				
				userDataLists.html(domDataHTML)
			} else {
				console.log("No response here !")
			}
		}
	})
}


const addData = (param, type) => {
	let endPoint = ''
	let prepareData = {}

	switch(type) {
	case 'data-user':
		endPoint = `/add/${type}`
		prepareData = {
			nm_lengkap: param.data.nm_lengkap,
			alamat: param.data.alamat,
			notlp: param.data.notlp,
			role: param.data.role
		}
		break;
		// type lainnya ...

	default:
	}

	$.ajax({
		url: endPoint,
		type: 'POST',
		dataType: 'json',
		data: prepareData,
		startTime: new Date().getTime(),
		success: function(response) {
			const successData = response

			let time = (new Date().getTime() - this.startTime);
			
			if(successData.error) {
				loadingBtn.addClass('hidden')
				textBtn.removeClass('hidden')
				alertError.show();
				messageError.html(`
					<span class="font-medium"> Ooops!</span>${successData.message}!
					`)
				Swal.fire({
					icon: 'error',
					title: 'Oops...',
					text: successData.message
				})
			}

			if(successData.success) {
				console.log("This request took "+time+" ms");
				$('input[name="nm_lengkap"]').val('')
				$('textarea[name="alamat"]').val('')
				$('input[name="notlp"]').val('')
				$('#role').val('Pilih Role')
				setTimeout(() => {
					alertSuccess.show();
					messageSuccess.html(`
						<span class="font-medium"> Berhasil menambah pengguna baru!</span> ${successData.message}
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

					// addUserModal.addClass('hidden');

				}, 1000)
			}
		}
	})
}

const updateData = (param, type) => {
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
		// type lainnya ....

	default:
	}

	$.ajax({
		url: endPoint,
		type: 'POST',
		dataType: 'json',
		data: prepareData,
		startTime: new Date().getTime(),
		success: function(response) {
			const successData = response

			let time = (new Date().getTime() - this.startTime);

			if(successData.success) {
				console.log("This request took "+time+" ms");

				setTimeout(() => {
					alertSuccess.show();
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

const deleteData = (param, type) => {
	let endPoint = ''
	switch(type) {
	case 'data-user':
		endPoint = `/delete/${type}/${param.id}`
		break;

	default:
	}

	$.ajax({
		url: endPoint,
		type: 'DELETE',
		dataType: 'json',
		data: `${param.field}=${param.id}`,
		startTime: new Date().getTime(),
		success: function(response) {

			const successData = response
			
			let time = (new Date().getTime() - this.startTime);
			
			if(successData.success) {

				console.log("This request took "+time+" ms");

				setTimeout(() => {
					getAllData(type)
					alertSuccess.show();
					messageSuccess.html(`
						<span class="font-medium"> Deleted successfully!</span> ${successData.message}
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