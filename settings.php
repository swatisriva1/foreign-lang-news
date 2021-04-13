<?php
require('settingsDB.php');
session_start();

$username = $email = $fname = $lname = "";
$save_err = "";

if(!$_SESSION['loggedInFNA']) {
    header("Location: landing.php");
}

if ($_SESSION['user']) {
    $username = $_SESSION['user'];
}
else {
    header("Location: landing.php");    
}

if($_SERVER['REQUEST_METHOD'] == 'GET') {

    if(!empty($_GET['action']) && ($_GET['action']=='Logout')) {
        session_unset();
        session_destroy();
        setcookie("user", "", time()-3600, "/");
        header("Location:landing.php");
    }
}

loadUserInfo($username);

$languages = getUserLanguages($username);
$topics = getUserTopics($username);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (!empty($_POST["action"]) && $_POST["action"] == "save") {
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $email = $_POST['email'];
        $username = $_POST['username'];
        saveChanges($fname, $lname, $email, $username, $_POST['lang'], $_POST['topic']);
    } else {
        $save_err = "Unable to submit. Please try again";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <title>Settings</title> 
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="View aggregated news in multiple languages" />
        <meta name="author" content="Megan Reddy (mr8vn)" />
        <link href="css/stylesheet.css" rel="stylesheet" />
        <link href="css/common.css" rel="stylesheet" />
        <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>

        <style>
            .account-label, .pref-label {
                font-weight: bold;
            }
            .avatar {
                display: block;
                padding-top: 20px;
                margin-left: auto;
                margin-right: auto;
                width: 10%;
                border-radius: 50%;
            }
            .button-wrapper {
                color: #74b3ce;
                text-align: center;
            }
            .card-header {
                font-size: 20px;
                font-weight: bold;
            }
            .column {
                padding-left: 20px;
                float: left;
                width: 33%;
            }
            input[type=checkbox] {
                transform: scale(1.5);
                margin: .4rem;
            }
            .msg {
                color: red;
                font-style: italic;
            }           
        </style>

    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark">
            <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button>
            <a class="navbar-brand" href="home.php">Foreign Language News Aggregator</a>
            <!-- Navbar Search-->
            <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
                <div class="input-group">
                    <input class="form-control" type="text" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2" />
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="button"><i class="fas fa-search"></i></button>
                    </div>
                </div>
            </form>
            <!-- Navbar-->
            <ul class="navbar-nav ml-auto ml-md-0">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="userDropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                        <a class="dropdown-item" href="settings.php">Settings</a>
                        <a class="dropdown-item" href="#">Activity Log</a>
                        <div class="dropdown-divider"></div>
                        <!-- <a class="dropdown-item" href="landing.html">Logout</a> -->
                        <form action="<?php $_SERVER['PHP_SELF'] ?>" method="GET">
                            <input class="dropdown-item" type="submit" name="action" value="Logout" title="Logout"/>
                        </form>
                    </div>
                </li>
            </ul>
        </nav>
        <!-- Side navigation-->
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <h3 style="margin-left: 15px; margin-top: 20px;" class="menu-header">Following</h3>
                            <div class="sb-sidenav-menu-heading">Languages</div>
                            <a class="nav-link" id="menu-label" href="home.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-globe"></i></div>
                                <?php if (!empty($languages)) echo idToLang($languages[0]) ?>
                            </a>
                            <a class="nav-link" id="menu-label" href="home.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-globe"></i></div>
                                <?php if (!empty($languages)) echo idToLang($languages[1]) ?>
                            </a>
                            <a class="nav-link" id="menu-label" href="home.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-globe"></i></div>
                                <?php if (!empty($languages)) echo idToLang($languages[2]) ?>
                            </a>
                            <div class="sb-sidenav-menu-heading">Topics</div>
                            <a class="nav-link" id="menu-label" href="home.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-bookmark"></i></div>
                                <?php if (!empty($topics)) echo idToTopic($topics[0]) ?>
                            </a>
                            <a class="nav-link" id="menu-label" href="home.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-bookmark"></i></div>
                                <?php if (!empty($topics)) echo idToTopic($topics[1]) ?>
                            </a>
                            <a class="nav-link" id="menu-label" href="home.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-bookmark"></i></div>
                                <?php if (!empty($topics)) echo idToTopic($topics[2]) ?>
                            </a>
                            <!-- <div class="sb-sidenav-menu-heading">Newspapers</div>
                            <a class="nav-link" id="menu-label" href="index.html">
                                <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
                                El Pais
                            </a>
                            <a class="nav-link" id="menu-label" href="index.html">
                                <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
                                El Mundo
                            </a>
                            <a class="nav-link" id="menu-label" href="index.html">
                                <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
                                Bild
                            </a> -->
                        </div>
                        <button style="margin-left: 15px; margin-top: 20px; margin-bottom: 20px;" class="btn btn-primary" id="preferences-btn" type="button">Edit Preferences</button> 
                    </div>
                </nav>
            </div>
            <!-- Settings/preferences-->
            <div id="layoutSidenav_content">
                <?php
                    // if (isset($_POST['fname'])) echo $_POST['fname'];
                    // if (isset($_POST['lname'])) echo $_POST['lname'];
                    // if (isset($_POST['email'])) echo $_POST['email'];
                    // if (isset($_POST['username'])) echo $_POST['username'];

                    // $checked_boxes = getCheckedBoxes($_POST['topic']);

                    // foreach ($checked_boxes as $box){ 
                    //     echo $box."<br />";
                    // } 

                    // $check = checkBox("science", $topics);

                    // echo $check;
                ?>
                <main>
                    <div class="container-fluid">
                        <img src="images/avatar.jpg" alt="Avatar" class="avatar">
                        <h1 style="text-align: center; margin-bottom: 50px;" class="mt-4">Jane Doe</h1>
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                            <div class="row">
                                <div class="col-xl-6">
                                    <div style="height: 500px;" class="card mb-4">
                                        <div class="card-header">
                                            Account Information
                                        </div>
                                        <div class="card-body">
                                            <!-- <form action="" method="POST"> -->
        
                                                <div class="form-group">
                                                <label for="fname" class="account-label">First Name</label>
                                                <input type="text" id="fname" name="fname" class="form-control" value="<?php if (!empty($fname)) echo $fname ?>"/>
                                                <span class="error" id="name-note"></span>        
                                                </div>

                                                <div class="form-group">
                                                <label for="lname" class="account-label">Last Name</label>
                                                <input type="text" id="lname" name="lname" class="form-control" value="<?php if (!empty($lname)) echo $lname ?>"/>
                                                <span class="error" id="name-note"></span>        
                                                </div>
                                                
                                                <div class="form-group">
                                                <label for="email" class="account-label">Email</label>  
                                                <input type="text" id="email" name="email" class="form-control" value="<?php if (!empty($email)) echo $email ?>"/>  
                                                <span class="error" id="email-note"></span>
                                                </div>
                                                
                                                <div class="form-group">
                                                <label for="username" class="account-label">Username</label>
                                                <input type="text" id="username" name="username" class="form-control" value="<?php if (!empty($username)) echo $username ?>"/>  
                                                <span class="error" id="username-note"></span>
                                                </div>  
                                                
                                                <!-- <label for="changeavatar" class="account-label">Avatar</label>
                                                <div class="form-group">
                                                    <form action="change_avatar.php">
                                                        <input type="file" id="changeavatar" name="avatar-file">
                                                    </form>
                                                </div>  -->

                                            <!-- </form> -->
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div style="height: 500px;" class="card mb-4">
                                        <div class="card-header">
                                            Preferences
                                        </div>
                                        <div class="card-body">
                                            <!-- <form action="" method="GET" name="user-preferences" > -->
                                                <div class="row">
                                                    <div class="column">
                                                        <label for="lang-options" class="pref-label">Languages</label>
                                                        <div id="lang-options">
                                                            <input type="checkbox" id="lang1" name="lang[]" value="fr" <?php if(checkBox("fr", $languages)) echo "checked=\"checked\""?>/>
                                                            <label for="lang1">French</label><br>
                                                            <input type="checkbox" id="lang2" name="lang[]" value="it" <?php if(checkBox("it", $languages)) echo "checked=\"checked\""?>/>
                                                            <label for="lang2">Italian</label><br>
                                                            <input type="checkbox" id="lang3" name="lang[]" value="kr" <?php if(checkBox("kr", $languages)) echo "checked=\"checked\""?>/>
                                                            <label for="lang3">Korean</label><br>
                                                            <input type="checkbox" id="lang4" name="lang[]" value="jp" <?php if(checkBox("jp", $languages)) echo "checked=\"checked\""?>/>
                                                            <label for="lang3">Japanese</label><br>
                                                        </div>
                                                        <span class="msg"><p id="lang_error"></p></span>
                                                    </div>
                                                    <div class="column">
                                                        <label for="topic-options" class="pref-label">Topics</label>
                                                        <div id="topic-options">
                                                            <label><input type="checkbox" id="topic1" name="topic[]" value="sports" <?php if(checkBox("sports", $topics)) echo "checked=\"checked\""?>/>
                                                            <label for="topic1">Sports</label><br>
                                                            <label><input type="checkbox" id="topic2" name="topic[]" value="health" <?php if(checkBox("health", $topics)) echo "checked=\"checked\""?>/>
                                                            <label for="topic2">Health</label><br>
                                                            <label><input type="checkbox" id="topic3" name="topic[]" value="science" <?php if(checkBox("science", $topics)) echo "checked=\"checked\""?>/>
                                                            <label for="topic3">Science</label><br>
                                                            <label><input type="checkbox" id="topic4" name="topic[]" value="business" <?php if(checkBox("business", $topics)) echo "checked=\"checked\""?>/>
                                                            <label for="topic3">Business</label><br>
                                                        </div>
                                                        <span class="msg"><p id="topic_error"></p></span>
                                                    </div>
                                                    <!-- <div class="column">
                                                        <label for="newspaper-options" class="pref-label">Newspapers</label>
                                                        <div id="newspaper-options">
                                                            <label><input type="checkbox" id="news1" name="news" value="elpais"/>
                                                            <label for="topic1">El Pais</label><br>
                                                            <label><input type="checkbox" id="news2" name="news" value="elmundo" checked/>
                                                            <label for="topic2">El Mundo</label><br>
                                                            <label><input type="checkbox" id="news3" name="news" value="bild" checked/>
                                                            <label for="topic3">Bild</label><br>
                                                        </div>
                                                        <span class="msg"><p id="news_error"></p></span>
                                                    </div> -->
                                                </div>
                                            <!-- </form> -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="button-wrapper">
                                <button style="margin-bottom: 30px;" class="btn btn-primary" id="save-btn" name="action" value="save">Save Changes</button>
                            </div>
                            <span class="error_message"><?php if(!empty($save_err)) echo $save_err; ?></span>
                        </form>
                    </div>
                </main>
                <!-- Footer-->
                <div id="layoutAuthentication_footer">
                    <footer class="py-4 mt-auto">
                        <div class="container-fluid">
                            <div class="d-flex align-items-center justify-content-between small">
                                <div class="text-muted">Copyright &copy; Foreign Language News Aggregator 2021</div>
                                <div>
                                    <a href="#">Privacy Policy</a>
                                    &middot;
                                    <a href="#">Terms &amp; Conditions</a>
                                </div>
                            </div>
                        </div>
                    </footer>
                </div>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <!-- <script src="js/scripts.js"></script> -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/chart-area-demo.js"></script>
        <script src="assets/demo/chart-bar-demo.js"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/datatables-demo.js"></script>
        <script src="js/settings.js"></script>
        <script src="js/common.js"></script>
    </body>
</html>
