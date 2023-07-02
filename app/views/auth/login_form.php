
<section id="login" class="grid grid-cols-1 justify-items-stretch py-36">
	
	<?php if(isset($_GET['error'])): ?>
		<div class="col-span-full justify-self-center">
			<?php if(@$_GET['error'] === 'user_not_found'): ?>
				<div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
					<span class="font-medium">Oopps!</span> data user tidak ditemukan!.
				</div>
			<?php elseif(@$_GET['error'] === 'password_wrong') :?>
				<div class="p-4 mb-4 text-sm text-yellow-800 rounded-lg bg-yellow-50 dark:bg-gray-800 dark:text-yellow-300" role="alert">
					<span class="font-medium">Error Login!</span> username / password salah.
				</div>
			<?php else: ?>
				<div class="p-4 mb-4 text-sm text-blue-800 rounded-lg bg-blue-50 dark:bg-gray-800 dark:text-blue-400" role="alert">
					<span class="font-medium">Errror!</span> Change a few things up and try submitting again.
				</div>
			<?php endif;?>
		</div>
	<?php endif;?>
	<div class="col-span-full justify-self-center">
		<form action="/auth-login" method="POST">
			<div class="mb-6">
				<label for="username" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Username</label>
				<input type="text" id="username" name="username" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
			</div>
			<div class="mb-6">
				<label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password</label>
				<input type="password" id="password" name="password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
			</div>
			
			<button type="submit" name="login" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-full px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
		</form>

	</div>
</section>