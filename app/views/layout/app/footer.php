		
		<section id="footer">
			<?php require_once 'app/views/layout/partials/footer_content.php'; ?>
		</section>

		<script src="<?=$data['vendor']['flowbite']['js']?>"></script>

		<script src="<?=$data['vendor']['contentful']?>"></script>

		<script type="text/javascript">
			
		</script>

		<?php for($i=0; $i < count($partials['scripts']); $i++): ?>
			<script type="text/javascript" src="<?=$partials['scripts'][$i]?>"></script>
		<?php endfor;?>
	</body>
</html>