<?php 
	date_default_timezone_set('Europe/Amsterdam');
	session_start();

	include_once('mysql.php');

	$configjson = file_get_contents(dirname(__DIR__).'/inc/config.json');
	$configjson = json_decode($configjson);
	
	$version = $configjson->version;
	$language = $configjson->language;

	$lang = file_get_contents(dirname(__DIR__).'/inc/languages/'.$language.'.json');
    $lang = json_decode($lang);
	
	if (isset($_GET['methode'])){
		$methode = $_GET['methode'];
	} else {
		$methode = "";
	}

	// Login
	if (isset($_POST['login'])) {
		$username = $_POST['username'];
		$password = $_POST['password'];
		$password = md5($password);
		
		$pdoResult = $PDOdb->prepare("SELECT * FROM WebAddon_Users WHERE Username=:Username AND Password=:Password LIMIT 1");
		$pdoExec = $pdoResult->execute(array(":Username"=>$username, ":Password"=>$password));
		$rowcount = $pdoResult->rowCount();
		
		if($pdoExec){
			if($rowcount != 0){
				while($row = $pdoResult->fetch(PDO::FETCH_ASSOC)){
					$UserId = $row['Id'];
					$_SESSION['UserId'] = $UserId;
					
					header('location: ../accounts');
					echo '
					<script>
						location.replace("../accounts");
						window.location.href = "../accounts"
					</script>
					';
				}
			}else{
				$_SESSION['Error'] = "WrongUsernameOrPassword";
				echo 'wrong un / pw';
				header('location: ../');
				echo '
				<script>
					location.replace("../");
					window.location.href = "../"
				</script>
				';
			}
		}else{
			$_SESSION['Error'] = "dberror";
			echo 'db error';
			header('location: ../');
			echo '
			<script>
				location.replace("../");
				window.location.href = "../"
			</script>
			';
        }
	}
	
	// add user
	if (isset($_POST['adduser'])) {
		$UserId = $_SESSION['UserId'];
        $pdoResult = $PDOdb->prepare("SELECT * FROM WebAddon_Users WHERE Id=:Id LIMIT 1");
        $pdoExec = $pdoResult->execute(array(":Id"=>$UserId));
        $rowcount = $pdoResult->rowCount();
        
        if($pdoExec){
            if($rowcount != 0){
                while($row = $pdoResult->fetch(PDO::FETCH_ASSOC)){
                    $Role = $row['Role'];
                }
            }
        }else{
            echo 'Error';
        }

		if($Role == "admin"){
            $username = $_POST['username'];
			$password = $_POST['password'];
			$Role = $_POST['role'];
			$password = md5($password);
			
			$pdoResult = $PDOdb->prepare("SELECT * FROM WebAddon_Users WHERE Username=:Username");
			$pdoExec = $pdoResult->execute(array(":Username"=>$username));
			$rowcount = $pdoResult->rowCount();
			
			if($pdoExec){
				if($rowcount != 0){
					$_SESSION['Error'] = "usernametaken";
					header('location: ../settings');
					echo '
					<script>
						location.replace("../settings");
						window.location.href = "../settings"
					</script>
					';
				}else{
					$pdoResult = $PDOdb->prepare("INSERT INTO WebAddon_Users(Id, Username, Password, Role) VALUES (NULL, :Username, :Password, :Role)");
					$pdoExec = $pdoResult->execute(array(":Username"=>$username, ":Password"=>$password, ":Role"=>$Role));
					$rowcount = $pdoResult->rowCount();
					
					if($pdoExec){
						header('location: ../settings');
						echo '
						<script>
							location.replace("../settings");
							window.location.href = "../settings"
						</script>
						';
					}else{
						$_SESSION['Error'] = "dberror";
						header('location: ../settings');
						echo '
						<script>
							location.replace("../settings");
							window.location.href = "../settings"
						</script>
						';
				    }
				}
			}else{
				$_SESSION['Error'] = "dberror";
				
				header('location: ../');
				echo '
				<script>
					location.replace("../");
					window.location.href = "../"
				</script>
				';
	        }
        }else{
        	header('location: ../');
			echo '
			<script>
				location.replace("../");
				window.location.href = "../"
			</script>
			';
        }
	}
	
	//delete user
	if ($methode == "deleteuser") {
		$UserId = $_SESSION['UserId'];
        $pdoResult = $PDOdb->prepare("SELECT * FROM WebAddon_Users WHERE Id=:Id LIMIT 1");
        $pdoExec = $pdoResult->execute(array(":Id"=>$UserId));
        $rowcount = $pdoResult->rowCount();
        
        if($pdoExec){
            if($rowcount != 0){
                while($row = $pdoResult->fetch(PDO::FETCH_ASSOC)){
                    $Role = $row['Role'];
                }
            }
        }else{
            echo 'Error';
        }

		if($Role == "admin"){
			$UId = $_GET['UId'];
			
			$pdoResult = $PDOdb->prepare("DELETE FROM WebAddon_Users WHERE Id=:Id");
			$pdoExec = $pdoResult->execute(array(":Id"=>$UId));

			if($pdoExec){
				header('location: ../settings');
				echo '
				<script>
					location.replace("../settings");
					window.location.href = "../settings"
				</script>
				';
			}else{
				$_SESSION['Error'] = "dberror";
				
				header('location: ../settings');
				echo '
				<script>
					location.replace("../settings");
					window.location.href = "../settings"
				</script>
				';
		    }
		}else{
        	header('location: ../');
			echo '
			<script>
				location.replace("../");
				window.location.href = "../"
			</script>
			';
        }
	}

	// Change Lang
	if (isset($_POST['updatelang'])) {
		$UserId = $_SESSION['UserId'];
        $pdoResult = $PDOdb->prepare("SELECT * FROM WebAddon_Users WHERE Id=:Id LIMIT 1");
        $pdoExec = $pdoResult->execute(array(":Id"=>$UserId));
        $rowcount = $pdoResult->rowCount();
        
        if($pdoExec){
            if($rowcount != 0){
                while($row = $pdoResult->fetch(PDO::FETCH_ASSOC)){
                    $Role = $row['Role'];
                }
            }
        }else{
            echo 'Error';
        }

		if($Role == "admin"){
			$lang = $_POST['lang'];
			
			$configjson = file_get_contents('config.json');
			$config = json_decode($configjson);

			$config = array(
				"version" => $config->version,
				"language" => $lang
			);

			$config = json_encode($config);
			file_put_contents("config.json", $config);
			
			header('location: ../settings');
			echo '
			<script>
				location.replace("../settings");
				window.location.href = "../settings"
			</script>
			';
		}else{
        	header('location: ../');
			echo '
			<script>
				location.replace("../");
				window.location.href = "../"
			</script>
			';
        }
	}
?>