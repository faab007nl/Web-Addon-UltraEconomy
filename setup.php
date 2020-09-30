<?php
    require_once "inc/Mobile_Detect.php";
    require_once "inc/gensetup.php";
    $detect = new Mobile_Detect;
    
    $configjson = file_get_contents('./inc/config.json');
	$configjson = json_decode($configjson);
	$version = $configjson->version;

	if(file_exists("./inc/dbconfig.php")){
		header('location: ./');
		echo '
		<script>
			location.replace("./");
			window.location.href = "./"
		</script>
		';
	}
?>
<!DOCTYPE html>
<html style="background: #efefef;">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Login - Ultra Economy</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i">
    <link rel="stylesheet" href="assets/fonts/fontawesome-all.min.css">
    <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="assets/fonts/fontawesome5-overrides.min.css">
    <link rel="stylesheet" href="assets/css/Login-Form-Clean.css">
    <link rel="stylesheet" href="assets/css/styles.css">
<link rel="icon" href="assets/img/icon.png">
</head>

<body id="page-top" style="background: #efefef;">
    <div class="login-clean" style="background: #efefef;">
        <form action="./inc/gensetup.php" method="post">
            <div class="illustration"><img class="img-fluid" src="assets/img/uecon.png"></div>
            <h3 class="text-center">UltraEconomy&nbsp;v<?php echo $version; ?></h3>
            <p class="text-center">Web Addon by <a href="https://www.spigotmc.org/members/faab007.324536/">Faab007NL</a></p>
            <h2 class="text-center">Setup</h2>
            <?php
                if(isset($_SESSION['Error'])){
                    if($_SESSION['Error'] == "dbconerror"){
                        echo '<div class="error_msg"><strong>Can`t connect to Database.</strong></div>';
                    }
                    if($_SESSION['Error'] == "dberror"){
                        echo '<div class="error_msg"><strong>An unknown error has occurred!</strong></div>';
                    }
                    $_SESSION['Error'] = "";
                }
            ?>
            <h5>Database</h5>
            <div class="form-group">
                <input class="form-control" type="text" placeholder="Hostname" name="dbhostname" required>
            </div>
            <div class="form-group">
                <input class="form-control" type="text" placeholder="Database" name="dbdatabase" required>
            </div>
            <div class="form-group">
                <input class="form-control" type="text" placeholder="Username" name="dbusername" required>
            </div>
            <div class="form-group">
                <input class="form-control" type="text" placeholder="Password" name="dbpassword" required>
            </div>
            <hr>
            <h5>Admin Login</h5>
            <div class="form-group">
                <input class="form-control" type="text" placeholder="Username" name="username" required>
            </div>
            <div class="form-group">
                <input class="form-control" type="text" placeholder="Password" name="password" required>
            </div>
            <div class="form-group">
                <button class="btn btn-primary btn-block btnsubmit" value="Done" name="setup" type="submit">Done</button>
            </div>
        </form>
    </div>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.js"></script>
    <script src="assets/js/theme.js"></script>
</body>
</html>