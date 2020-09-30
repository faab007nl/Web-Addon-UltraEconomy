<?php
	include 'server.php';
	
	session_destroy();
	unset($_SESSION['UserId']);
	unset($_SESSION['Username']);
	unset($_SESSION['Role']);
	
	header('location: ../');
	echo '
	<script>
		location.replace("../");
		window.location.href = "../"
	</script>
	';
?>