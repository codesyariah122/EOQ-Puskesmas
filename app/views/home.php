
<?php require_once $partials['navbar']; ?>

<body class="dark:bg-gray-800">
	<main class="flex flex-col min-h-screen bg-white dark:bg-gray-800 dark:text-white">

		<?php
			foreach($partials['views'] as $home):
				require_once $home;
			endforeach;
		?>
	</main>
