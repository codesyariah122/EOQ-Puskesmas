let loading = document.querySelector('#loading');
let loadingBtn = $('#loading-button')
let textBtn = $('#text-button')

setTimeout(() => {
	loading.classList.remove('block')
	loading.classList.add('hidden')
}, 1500)