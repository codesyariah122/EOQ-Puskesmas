


<section class="bg-center bg-no-repeat bg-[url('<?=$data['bg']?>')] bg-gray-700 bg-blend-multiply">
	<div class="px-4 mx-auto max-w-screen-xl text-center py-24 lg:py-56">

		<h1 class="mb-4 text-4xl font-extrabold tracking-tight leading-none text-white md:text-5xl lg:text-6xl">Welcome <?php if(isset($_SESSION['token'])){echo ucfirst($_SESSION['username']);}?></h1>
		<p class="mb-8 text-lg font-normal text-gray-300 lg:text-xl sm:px-16 lg:px-48">Sistem Informasi Pengelolaan Pengadaan Obat Balai Kesehatan.</p>
		<div class="flex flex-col space-y-4 sm:flex-row sm:justify-center sm:space-y-0 sm:space-x-4">
			<?php if($rows_count['total'] > 0): ?>
				<a href="/login" class="inline-flex justify-center items-center py-3 px-5 text-base font-medium text-center text-white rounded-lg bg-blue-700 hover:bg-orange-800 focus:ring-4 focus:ring-blue-300 dark:focus:ring-blue-900">
					Get started
					<svg aria-hidden="true" class="ml-2 -mr-1 w-4 h-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
				</a>
			<?php else:?>
				<a href="/create-user" class="inline-flex justify-center items-center py-3 px-5 text-base font-medium text-center text-white rounded-lg bg-orange-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 dark:focus:ring-blue-900">
					Create User
					<svg aria-hidden="true" class="ml-2 -mr-1 w-4 h-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
				</a>
			<?php endif; ?>
			<a href="#" class="inline-flex justify-center hover:text-gray-900 items-center py-3 px-5 text-base font-medium text-center text-white rounded-lg border border-white hover:bg-gray-100 focus:ring-4 focus:ring-gray-400">
				Learn more
			</a>  
		</div>
	</div>
</section>

<?php if(isset($_GET['error'])): ?>

<?php if($_GET['error'] === 'forbaiden'):?>
	<section class="flex justify-center w-full py-24 mb-12">
		<div>
			<div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
				<span class="font-medium">Ooops!</span> you has access dashboard page without login.
			</div>
		</div>
		<script type="text/javascript">
			Swal.fire({
				title: 'Ooops!! please login first, before access dashboard page.',
				width: 600,
				padding: '3em',
				color: '#716add',
				background: '#fff url(https://sweetalert2.github.io/images/trees.png)',
				backdrop: `
				rgba(0,0,123,0.4)
				url("https://sweetalert2.github.io/images/nyan-cat.gif")
				left top
				no-repeat
				`
			})
		</script>
	</section>
<?php endif; ?>

<?php endif; ?>