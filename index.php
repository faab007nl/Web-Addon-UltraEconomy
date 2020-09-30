<?php
    include 'inc/server.php';

    if(isset($_SESSION['UserId'])){
        header('location: ./accounts');
        echo '
        <script>
            location.replace("./accounts");
            window.location.href = "./accounts"
        </script>
        ';
    }
?>
<!DOCTYPE html>
<html style="background: #efefef;">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title><?php echo $lang->login; ?> - Ultra Economy</title>
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
        <form action="inc/server.php" method="post">
            <div class="illustration"><img class="img-fluid" src="assets/img/uecon.png"></div>
            <h3 class="text-center">UltraEconomy&nbsp;v<?php echo $version; ?></h3>
        	<p class="text-center"><?php echo $lang->webaddonby; ?> <a href="https://www.spigotmc.org/members/faab007.324536/">Faab007NL</a></p>
            <h2 class="text-center"><?php echo $lang->login; ?></h2>
            <?php
                if(isset($_SESSION['Error'])){
                    if($_SESSION['Error'] == "WrongUsernameOrPassword"){
                        echo '<div class="error_msg"><strong>'.$lang->loginwrong.'</strong></div>';
                    }
                    if($_SESSION['Error'] == "dberror"){
                        echo '<div class="error_msg"><strong>'.$lang->dberror.'</strong></div>';
                    }
                    $_SESSION['Error'] = "";
                }
            ?>
            <div class="form-group">
            	<input class="form-control" type="text" name="username" placeholder="<?php echo $lang->username; ?>" required="" autofocus="">
            </div>
            <div class="form-group">
            	<input class="form-control" type="password" name="password" placeholder="<?php echo $lang->password; ?>" required="">
            </div>
            <div class="form-group">
            	<button class="btn btn-primary btn-block" value="<?php echo $lang->login; ?>" name="login" type="submit"><?php echo $lang->login; ?></button>
            </div>
        </form>
    </div>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.js"></script>
    <script src="assets/js/theme.js"></script>
</body>

</html>