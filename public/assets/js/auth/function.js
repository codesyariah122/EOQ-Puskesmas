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
				loginTime = userData.data.login_time
				countdown(userData.data.login_time ? userData.data.login_time : loginTime)
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



function countdown(targetTime) {
  let targetDate = new Date(targetTime * 1000).getTime();
  let now = new Date().getTime();
  let timeRemaining = targetDate - now;

  // Konversi waktu dalam milidetik ke hari, jam, menit, detik
  let days = Math.floor(timeRemaining / (1000 * 60 * 60 * 24));
  let hours = Math.floor((timeRemaining % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
  let minutes = Math.floor((timeRemaining % (1000 * 60 * 60)) / (1000 * 60));
  let seconds = Math.floor((timeRemaining % (1000 * 60)) / 1000);

  // Tampilkan waktu hitung mundur dalam elemen dengan ID "countdown"
  $('#sesi-login').html(days + " hari " + hours + " jam " + minutes + " menit " + seconds + " detik ");

  // Perbarui waktu setiap detik (1000 milidetik)
  setTimeout(countdown, 1000, targetTime);
}