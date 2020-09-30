<?php
    include 'inc/functions.php';
    include 'inc/server.php';
    require_once "inc/Mobile_Detect.php";

    $detect = new Mobile_Detect;    
    if(isset($_SESSION['UserId'])){
        $UserId = $_SESSION['UserId'];
        $pdoResult = $PDOdb->prepare("SELECT * FROM WebAddon_Users WHERE Id=:Id LIMIT 1");
        $pdoExec = $pdoResult->execute(array(":Id"=>$UserId));
        $rowcount = $pdoResult->rowCount();
        
        if($pdoExec){
            if($rowcount != 0){
                while($row = $pdoResult->fetch(PDO::FETCH_ASSOC)){
                    $username = $row['Username'];
                    $Role = $row['Role'];
                }
            }
        }else{
            echo '
            <div style="background-color: rgba(255,0,0,0.6); position: absolute; top: 0px; left: 0px; bottom:0px; right: 0px; z-index: 5000; cursor: wait;">
                <div style="position: absolute;top: 25%; left: 10%;font-size: 50px; width:80%; color: white;">
                    <p style="text-align: center;">Can`t connect to DataBase<br/>Please check the dbconfig.php file</p>
                </div>
            </div>';
        }
    }else{
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
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title><?php echo $lang->currencies; ?> - Ultra Economy</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i">
    <link rel="stylesheet" href="assets/fonts/fontawesome-all.min.css">
    <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="assets/fonts/fontawesome5-overrides.min.css">
    <link rel="stylesheet" href="assets/css/Login-Form-Clean.css">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="icon" href="assets/img/icon.png">
</head>

<body id="page-top">
    <?php 
        if($Role == "admin"){
            $newUpdate = CheckForUpdates(); 

            if($newUpdate == true){
                echo '
                    <div class="NewUpdate">
                        <span><strong>There is a new update available!</strong></span></br>
                        <span>Go to the settings to download it!</span>
                    </div>
                ';
            }
        }
    ?>
    <div id="wrapper">
        <nav class="navbar navbar-dark align-items-start sidebar sidebar-dark accordion bg-gradient-primary p-0">
            <div class="container-fluid d-flex flex-column p-0"><a class="navbar-brand d-flex justify-content-center align-items-center sidebar-brand m-0"><img class="img-fluid MenuHeader" src="assets/img/uecon.png"></a>
                <ul class="nav navbar-nav text-light" id="accordionSidebar">
                    <li class="nav-item"><a class="nav-link" href="./accounts"><i class="fas fa-users"></i><span><?php echo $lang->accounts; ?></span></a></li>
                    <li class="nav-item"><a class="nav-link active" href="./currencies"><i class="fas fa-money-bill-wave"></i><span><?php echo $lang->currencies; ?></span></a></li>
                    <li class="nav-item"><a class="nav-link" href="./trades"><i class="fas fa-book"></i><span><?php echo $lang->loggedtrades; ?></span></a></li>
                    <li class="nav-item"><a class="nav-link" href="./transactions"><i class="fas fa-exchange-alt"></i><span><?php echo $lang->transactions; ?></span></a></li>
                    <?php
                        if($Role == "admin"){
                            echo '<li class="nav-item"><a class="nav-link" href="./settings"><i class="fas fa-gear"></i><span>'.$lang->settings.'</span></a></li>';
                        }
                    ?>
                    <li class="nav-item"><a class="nav-link" href="./inc/logout.php"><i class="fa fa-sign-out"></i><?php echo $lang->signout; ?></a></li>
                </ul>
            </div>
        </nav>
        <div class="d-flex flex-column" id="content-wrapper">
            <div id="content">
                <nav class="navbar navbar-light navbar-expand bg-white shadow mb-4 topbar static-top">
                    <div class="container-fluid"><button class="btn btn-link d-md-none rounded-circle mr-3" id="sidebarToggleTop" type="button"><i class="fas fa-bars"></i></button>
                        <ul class="nav navbar-nav flex-nowrap ml-auto">
                            <li class="nav-item dropdown d-sm-none no-arrow"><a class="dropdown-toggle nav-link" data-toggle="dropdown" aria-expanded="false" href="#"><i class="fas fa-search"></i></a>
                                <div class="dropdown-menu dropdown-menu-right p-3 animated--grow-in" aria-labelledby="searchDropdown">
                                    <form class="form-inline mr-auto navbar-search w-100">
                                        <div class="input-group"><input class="bg-light form-control border-0 small" type="text" placeholder="Search for ...">
                                            <div class="input-group-append"><button class="btn btn-primary py-0" type="button"><i class="fas fa-search"></i></button></div>
                                        </div>
                                    </form>
                                </div>
                            </li>
                            <li class="nav-item dropdown no-arrow"><span><?php echo $username; ?></span></li>
                        </ul>
                    </div>
                </nav>
                <div class="container-fluid">
                    <div class="d-sm-flex justify-content-between align-items-center mb-4">
                        <h3 class="text-dark mb-0"><?php echo $lang->currencies; ?><br></h3>
                    </div>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th><strong><?php echo $lang->name; ?></strong></th>
                                    <th><?php echo $lang->description; ?></th>
                                    <th><?php echo $lang->icon; ?></th>
                                    <th><?php echo $lang->main; ?></th>
                                    <th><strong><?php echo $lang->formatsingular; ?></strong><br></th>
                                    <th><strong><?php echo $lang->formatplural; ?></strong><br></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $pdoResult1 = $PDOdb->prepare("SELECT * FROM ultraeconomy_currencies ORDER BY ultraeconomy_currencies.key DESC");
                                    $pdoExec1 =  $pdoResult1->execute();

                                    if($pdoExec1){
                                        while($row1 = $pdoResult1->fetch(PDO::FETCH_ASSOC)){
                                            $data = base64_decode($row1['value']);
                                            $data = json_decode($data, true);

                                            $name = $data['name'];
                                            $description = $data['description'];
                                            $icon = $data['icon'];
                                            $main = $data['main'];
                                            $singular = $data['format']['singular'];
                                            $plural = $data['format']['plural'];

                                            if($main == true){
                                                $main = $lang->true;
                                            }else{
                                                $main = $lang->false;
                                            }

                                            echo '
                                                <tr>
                                                    <td class="table-cell">'.$name.'</td>
                                                    <td class="table-cell">'.$description.'</td>
                                                    <td class="table-cell"><img src="https://ultrapluginswebaddons.com/new/uecon/mcicons/'.$icon.'.png" height="20px"> '.$icon.'</td>
                                                    <td class="table-cell">'.$main.'</td>
                                                    <td class="table-cell">'.$singular.'</td>
                                                    <td class="table-cell">'.$plural.'</td>
                                                </tr>
                                            ';
                                        }
                                    }else{
                                        echo 'Error Loading Warnings';
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <footer class="bg-white sticky-footer">
                <div class="container my-auto">
                    <div class="text-center my-auto copyright">
                        <span>Copyright © <a href="https://ultrapluginswebaddons.com/" target="__BLANK">ultrapluginswebaddons.com</a> 2020</span><br>
                        <span><?php echo $lang->webaddonby; ?> <a href="https://www.spigotmc.org/members/faab007.324536/">Faab007NL</a> 2020</span>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.js"></script>
    <script src="assets/js/theme.js"></script>
</body>

</html>