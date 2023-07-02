
<?php require_once $partials['navbar']; ?>

<body class="flex flex-col min-h-screen">
	
	<main class="bg-white dark:bg-gray-800 dark:text-white">
		
		<?php
		foreach($partials['views'] as $error_404):
			require_once $error_404;
		endforeach;
		?>

	</main>
