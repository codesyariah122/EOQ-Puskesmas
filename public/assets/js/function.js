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

const setUpPagination = (data) => {
	pagination.empty();
	paging.totalData=data.totalData
	paging.countPage=data.countPage
	paging.totalPage=data.totalPage
	paging.aktifPage=data.aktifPage

	const prevEl = document.createElement('li')
	const nextEl = document.createElement('li')
	prevEl.innerHTML = `
		<li><a href="#" class="page-link flex items-center justify-center px-3 h-8 ml-0 leading-tight border  rounded-l-lg  dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white ${paging.aktifPage > 1 ? 'bg-blue-50 border-blue-300 text-blue-600 cursor-pointer' : 'bg-white border-gray-300 text-gray-500 cursor-not-allowed' }" data-num="${paging.aktifPage > 1 ? paging.aktifPage - 1 : paging.aktifPage - 1}"><i class="fa-solid fa-angle-left"></i>&nbsp;Previous</a></li>
	`
	nextEl.innerHTML = `
		<li><a href="#" class="page-link flex items-center justify-center px-3 h-8 ml-0 leading-tight border  rounded-r-lg  dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white ${paging.aktifPage < paging.totalPage ? 'bg-blue-50 border-blue-300 text-blue-600 cursor-pointer' : 'bg-white border-gray-300 text-gray-500 cursor-not-allowed' }" data-num="${paging.aktifPage < paging.totalPage ? paging.aktifPage + 1 : paging.aktifPage + 1}">Next&nbsp;<i class="fa-solid fa-angle-right"></i></a></li>
	`

	pagination.append(prevEl)

	for (let i = 1; i <= paging.totalPage; i++) {
		let pageLink = $(`<li><a href="#" class="page-link flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white ${i == paging.aktifPage ? 'cursor-not-allowed' : 'cursor-pointer'}" data-num="${i}">${i}</a></li>`);
		if (i === paging.aktifPage) {
			pageLink.find('a').addClass('text-blue-600 border border-gray-300 bg-blue-50 hover:bg-blue-100 hover:text-blue-700 dark:border-gray-700 dark:bg-gray-700 dark:text-white');
		}
		pagination.append(pageLink);
	}

	pagination.append(nextEl)

}

const getAllData = (type, page=1) => {
	const endPoint = `/lists/${type}?page=${page}`
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

				// pagination
				setUpPagination(lists)
			} else {
				console.log("No response here !")
			}
		}
	})
}

const searchData = (param, type) => {
	let endPoint = ''
	let prepareData = {}

	switch(type) {
		case 'data-user':
			endPoint = `/lists/${type}?keyword=${param.data}`
			prepareData = {
				keyword: param.data
			}
		break;
			// type lainnya ...

		default:
	}

	$.ajax({
		url: endPoint,
		type: 'GET',
		dataType: 'json',
		startTime: new Date().getTime(),
		success: function(response) {
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

				setUpPagination(lists)
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
			const responseData = response

			let time = (new Date().getTime() - this.startTime);
			
			if(responseData.error) {
				alertSuccess.hide()
				messageSuccess.html('')
				loadingBtn.addClass('hidden')
				textBtn.removeClass('hidden')
				alertError.show();
				messageError.html(`
					<span class="font-medium"> Ooops!</span>${responseData.message}!
					`)
				Swal.fire({
					icon: 'error',
					title: 'Oops...',
					text: responseData.message
				})
			}

			if(responseData.success) {
				alertError.hide()
				messageError.html('')
				console.log("This request took "+time+" ms");
				$('input[name="nm_lengkap"]').val('')
				$('textarea[name="alamat"]').val('')
				$('input[name="notlp"]').val('')
				$('#role').val('Pilih Role')
				setTimeout(() => {
					alertSuccess.show();
					messageSuccess.html(`
						<span class="font-medium"> Berhasil menambah pengguna baru!</span> ${responseData.message}
						`)

					loadingBtn.addClass('hidden')
					textBtn.removeClass('hidden')
					Swal.fire({
						position: 'top-end',
						icon: 'success',
						title: responseData.message,
						showConfirmButton: false,
						timer: 1500
					})

					getAllData(type, 1)

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

			const responseData = response

			console.log(responseData)

			let time = (new Date().getTime() - this.startTime);

			if(responseData.error) {
				alertSuccess.hide()
				messageSuccess.html('')
				loadingBtn.addClass('hidden')
				textBtn.removeClass('hidden')
				alertError.show();
				messageError.html(`
					<span class="font-medium"> Ooops!</span>${responseData.message}!
					`)
				Swal.fire({
					icon: 'error',
					title: 'Oops...',
					text: responseData.message
				})
			}

			if(responseData.success) {
				console.log("This request took "+time+" ms");

				setTimeout(() => {
					alertSuccess.show();
					messageSuccess.html(`
						<span class="font-medium"> Update successfully!</span> ${responseData.message}
						`)

					loadingBtn.addClass('hidden')
					textBtn.removeClass('hidden')
					Swal.fire({
						position: 'top-end',
						icon: 'success',
						title: responseData.message,
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

			const responseData = response
			
			let time = (new Date().getTime() - this.startTime);
			
			if(responseData.success) {
				console.log("This request took "+time+" ms");

				setTimeout(() => {
					loading.classList.remove('block')
					loading.classList.add('hidden')
					getAllData(type)
					alertSuccess.show();
					messageSuccess.html(`
						<span class="font-medium"> Deleted successfully!</span> ${responseData.message}
						`)
					loadingBtn.addClass('hidden')
					textBtn.removeClass('hidden')
					Swal.fire({
						position: 'top-end',
						icon: 'success',
						title: responseData.message,
						showConfirmButton: false,
						timer: 1500
					})
				}, 1000)
			}
		}
	})
}