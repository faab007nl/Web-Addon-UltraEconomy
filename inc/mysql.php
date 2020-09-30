<?php
	if(file_exists(dirname(__DIR__)."/inc/dbconfig.php")){
      	include dirname(__DIR__).'/inc/dbconfig.php';
      	
      	// connect to database
		$db = mysqli_connect($dbhostname, $dbusername, $dbpassword, $dbdatabase);
		
		try{
			$PDOdb = new PDO("mysql:host=".$dbhostname.";dbname=".$dbdatabase, $dbusername, $dbpassword);
			//echo "MySQL Connected!";
		}catch(PdoException $e){
			$error_message = $e->getMessage();
			echo '
			<div style="background-color: rgba(255,0,0,0.6); position: absolute; top: 0px; left: 0px; bottom:0px; right: 0px; z-index: 5000; cursor: wait;">
				<div style="position: absolute;top: 25%; left: 10%;font-size: 50px; width:80%; color: white;">
					<p style="text-align: center;">Can`t connect to DataBase<br/>Please check the dbconfig.php file</p>
				</div>
			</div>';
		}

		
  	}else{
  		header('location: ./setup');
		echo '
		<script>
			location.replace("./setup");
			window.location.href = "./setup"
		</script>
		';
  	}
?>