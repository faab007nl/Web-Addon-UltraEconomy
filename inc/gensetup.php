<?php
	date_default_timezone_set('Europe/Amsterdam');
	session_start();

	// Setup
	if (isset($_POST['setup'])) {
		if(file_exists("./inc/dbconfig.php")){
			header('location: ../');
			echo '
			<script>
				location.replace("../");
				window.location.href = "../"
			</script>
			';
		}else{
			$dbhostname = $_POST['dbhostname'];
			$dbdatabase = $_POST['dbdatabase'];
			$dbusername = $_POST['dbusername'];
			$dbpassword = $_POST['dbpassword'];

			$username = $_POST['username'];
			$password = $_POST['password'];
			$password = md5($password);

			try{
				$PDOdb = new PDO("mysql:host=".$dbhostname.";dbname=".$dbdatabase, $dbusername, $dbpassword);
				//echo "MySQL Connected!";
			}catch(PdoException $e){
				$error_message = $e->getMessage();
				$_SESSION['Error'] = "dbconerror";
				echo 'cant connect to db';
				
				//header('location: ../setup');
				echo '
				<script>
					//location.replace("../setup");
					//window.location.href = "../setup"
				</script>
				';
				exit();
			}

			$pdoResult = $PDOdb->prepare("CREATE TABLE `WebAddon_Users` ( `Id` INT NOT NULL AUTO_INCREMENT , `Username` VARCHAR(100) NOT NULL , `Password` VARCHAR(100) NOT NULL , `Role` VARCHAR(20) NOT NULL , PRIMARY KEY (`Id`));");
			$pdoExec = $pdoResult->execute();
			$rowcount = $pdoResult->rowCount();
			
			if($pdoExec){
				$pdoResult = $PDOdb->prepare("INSERT INTO WebAddon_Users(Id, Username, Password, Role) VALUES (NULL, :Username, :Password, :Role)");
				$pdoExec = $pdoResult->execute(array(":Username"=>$username, ":Password"=>$password, ":Role"=>"admin"));
				$rowcount = $pdoResult->rowCount();
				
				if($pdoExec){
					session_destroy();
					$dbconfig = '<?php $dbhostname="'.$dbhostname.'";$dbdatabase="'.$dbdatabase.'";$dbusername="'.$dbusername.'";$dbpassword="'.$dbpassword.'"; ?>';
					file_put_contents("dbconfig.php", $dbconfig);
					
					header('location: ../');
					echo '
					<script>
						location.replace("../");
						window.location.href = "../"
					</script>
					';
				}else{
					$_SESSION['Error'] = "dberror";
					
					header('location: ../setup');
					echo '
					<script>
						location.replace("../setup");
						window.location.href = "../setup"
					</script>
					';
			    }
			}else{
				$_SESSION['Error'] = "dberror";
				
				header('location: ../setup');
				echo '
				<script>
					location.replace("../setup");
					window.location.href = "../setup"
				</script>
				';
		    }
		}
	}
?>