

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script type="text/javascript">
	let name = "<?=$_SESSION['name']?>"
	let expired_login = "<?=$_SESSION['login_time']?>"
</script>

<?php for($i=0; $i < count($partials['scripts']); $i++): ?>
	<script type="text/javascript" src="<?=$partials['scripts'][$i]?>"></script>
<?php endfor;?>

</body>
</html>