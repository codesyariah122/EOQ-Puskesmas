let loading = document.querySelector('#loading')
let alertSuccess = $('#alert-success')
let messageSuccess = $('#message-success')
let alertError = $('#alert-error')
let messageError = $('#message-error')
let loadingBtn = $('#loading-button')
let textBtn = $('#text-button')
let userDataLists = $('#user-data')
let addUserModal = $('#addUserModal')
let pagination = $('#pagination')
let paging = {}

setTimeout(() => {
	loading.classList.remove('block')
	loading.classList.add('hidden')
}, 1500)