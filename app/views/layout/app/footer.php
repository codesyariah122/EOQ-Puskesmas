
<?php if(isset($page)): ?>
	<?php if($page !== 'login'):?>
		<section id="footer">
			<?php require_once 'app/views/layout/partials/footer_content.php'; ?>
		</section>
	<?php endif;?>
<?php endif;?>

		<script src="<?=$data['vendor']['flowbite']['js']?>"></script>


		<?php for($i=0; $i < count($partials['scripts']); $i++): ?>
			<script type="text/javascript" src="<?=$partials['scripts'][$i]?>"></script>
		<?php endfor;?>
		
	</body>
</html>