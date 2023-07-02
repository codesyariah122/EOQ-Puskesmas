const loading = document.querySelector('#loading');


setTimeout(() => {
	loading.classList.remove('block')
	loading.classList.add('hidden')
}, 1500)