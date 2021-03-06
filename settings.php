<?php
require('settingsDB.php');
session_start();

$username = $email = $fname = $lname = "";
$save_err = "";

// if(!$_SESSION['loggedInFNA']) {
//     header("Location: landing.php");
// }

if(!$_SESSION['loggedInFNA'] || !isset($_COOKIE['user'])) {
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
        // $username = $_POST['username'];
        saveChanges($fname, $lname, $email, $username, $_POST['lang'], $_POST['topic']);
        header("Location: home.php");
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
        <title>Settings - Hello World</title> 
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="Allow user to edit language and topic preferences" />
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
                /* color: #74b3ce; */
                text-align: center;
            }
            #save-btn {
                color: #eeeeee;
                background-color: #74b3ce; 
                border-color:  #74b3ce;
            }
            #save-btn:enabled {
                color: white; 
            }
            #save-btn:hover:enabled {
                background-color: #508991 !important; 
                border-color: #508991 !important; 
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
            .directions {
                color: black;
                font-style: italic;
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
            <a style="font-size: 30px;" class="navbar-brand" href="home.php">Hello World</a>
            <!-- Navbar Search-->
            <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
                <!-- <div class="input-group">
                    <input class="form-control" type="text" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2" />
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="button"><i class="fas fa-search"></i></button>
                    </div>
                </div> -->
            </form>
            <h5 class="my-md-0">Hi, <?php if (isset($_COOKIE['user'])) echo getUserFname($_COOKIE['user']) ?></h5>
            <!-- Navbar-->
            <ul class="navbar-nav ml-auto ml-md-0">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="userDropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                        <a class="dropdown-item" href="langinfo.php">Language Info</a>
                        <a class="dropdown-item" href="http://localhost:4200/">Questions</a>
                        <a class="dropdown-item" href="settings.php">Settings</a>
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
                        <h1 style="text-align: center;" class="mt-4"><?php if (!empty($fname) && !empty($lname)) echo $fname . " " . $lname ?></h1>
                        <h3 style="text-align: center; margin-bottom: 50px;" class="mt-4"><?php if (!empty($username)) echo $username ?></h3>
                        <form id="settings-info" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                            <div class="row">
                                <div class="col-xl-6">
                                    <div style="height: 550px;" class="card mb-4">
                                        <div class="card-header">
                                            Account Information
                                        </div>
                                        <div class="card-body">
                                            
                                            <div class="form-group">
                                            <label for="fname" class="account-label">First Name</label>
                                            <input type="text" id="fname" name="fname" class="form-control" value="<?php if (!empty($fname)) echo $fname ?>"/>
                                            <span class="error msg" id="fname-note"></span>        
                                            </div>

                                            <div class="form-group">
                                            <label for="lname" class="account-label">Last Name</label>
                                            <input type="text" id="lname" name="lname" class="form-control" value="<?php if (!empty($lname)) echo $lname ?>"/>
                                            <span class="error msg" id="lname-note"></span>        
                                            </div>
                                            
                                            <div class="form-group">
                                            <label for="email" class="account-label">Email</label>  
                                            <input type="text" id="email" name="email" class="form-control" value="<?php if (!empty($email)) echo $email ?>"/>  
                                            <span class="error msg" id="email-note"></span>
                                            </div>
                                            
                                            <!-- <label for="changeavatar" class="account-label">Avatar</label>
                                            <div class="form-group">
                                                <form action="change_avatar.php">
                                                    <input type="file" id="changeavatar" name="avatar-file">
                                                </form>
                                            </div>  -->
                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div style="height: 550px;" class="card mb-4">
                                        <div class="card-header">
                                            Preferences
                                        </div>
                                        <div class="card-body">
                                            <span class="directions">Select three languages and topics</p></span>
                                            <div class="row">
                                                <div class="column">
                                                    <label for="lang-options" class="pref-label">Languages</label>
                                                    <div id="lang-options">
                                                        <input type="checkbox" class="langbox" id="lang1" name="lang[]" value="fr" <?php if(checkBox("fr", $languages)) echo "checked=\"checked\""?>/>
                                                        <label for="lang1">French</label><br>
                                                        <input type="checkbox" class="langbox" id="lang2" name="lang[]" value="de" <?php if(checkBox("de", $languages)) echo "checked=\"checked\""?>/>
                                                        <label for="lang2">German</label><br>
                                                        <input type="checkbox" class="langbox" id="lang3" name="lang[]" value="it" <?php if(checkBox("it", $languages)) echo "checked=\"checked\""?>/>
                                                        <label for="lang3">Italian</label><br>
                                                        <input type="checkbox" class="langbox" id="lang4" name="lang[]" value="kr" <?php if(checkBox("kr", $languages)) echo "checked=\"checked\""?>/>
                                                        <label for="lang4">Korean</label><br>
                                                        <input type="checkbox" class="langbox" id="lang5" name="lang[]" value="jp" <?php if(checkBox("jp", $languages)) echo "checked=\"checked\""?>/>
                                                        <label for="lang5">Japanese</label><br>
                                                        <input type="checkbox" class="langbox" id="lang6" name="lang[]" value="cn" <?php if(checkBox("cn", $languages)) echo "checked=\"checked\""?>/>
                                                        <label for="lang6">Chinese</label><br>
                                                        <input type="checkbox" class="langbox" id="lang7" name="lang[]" value="nl" <?php if(checkBox("nl", $languages)) echo "checked=\"checked\""?>/>
                                                        <label for="lang7">Dutch</label><br>
                                                        <input type="checkbox" class="langbox" id="lang8" name="lang[]" value="no" <?php if(checkBox("no", $languages)) echo "checked=\"checked\""?>/>
                                                        <label for="lang8">Norwegian</label><br>
                                                        <input type="checkbox" class="langbox" id="lang9" name="lang[]" value="pt" <?php if(checkBox("pt", $languages)) echo "checked=\"checked\""?>/>
                                                        <label for="lang9">Portuguese</label><br>
                                                        <input type="checkbox" class="langbox" id="lang10" name="lang[]" value="ru" <?php if(checkBox("ru", $languages)) echo "checked=\"checked\""?>/>
                                                        <label for="lang10">Russian</label><br>
                                                        <span class="msg"><p id="lang_error"></p></span>
                                                    </div>
                                                </div>
                                                <div class="column">
                                                    <label for="topic-options" class="pref-label">Topics</label>
                                                    <div id="topic-options">
                                                        <label><input type="checkbox" class="topbox" id="topic1" name="topic[]" value="general" <?php if(checkBox("general", $topics)) echo "checked=\"checked\""?>/>
                                                        <label for="topic1">General</label><br>
                                                        <label><input type="checkbox" class="topbox" id="topic2" name="topic[]" value="sports" <?php if(checkBox("sports", $topics)) echo "checked=\"checked\""?>/>
                                                        <label for="topic2">Sports</label><br>
                                                        <label><input type="checkbox" class="topbox" id="topic3" name="topic[]" value="health" <?php if(checkBox("health", $topics)) echo "checked=\"checked\""?>/>
                                                        <label for="topic3">Health</label><br>
                                                        <label><input type="checkbox" class="topbox" id="topic4" name="topic[]" value="science" <?php if(checkBox("science", $topics)) echo "checked=\"checked\""?>/>
                                                        <label for="topic4">Science</label><br>
                                                        <label><input type="checkbox" class="topbox" id="topic5" name="topic[]" value="business" <?php if(checkBox("business", $topics)) echo "checked=\"checked\""?>/>
                                                        <label for="topic5">Business</label><br>
                                                        <label><input type="checkbox" class="topbox" id="topic5" name="topic[]" value="entertainment" <?php if(checkBox("entertainment", $topics)) echo "checked=\"checked\""?>/>
                                                        <label for="topic6">Entertainment</label><br>
                                                        <label><input type="checkbox" class="topbox" id="topic5" name="topic[]" value="technology" <?php if(checkBox("technology", $topics)) echo "checked=\"checked\""?>/>
                                                        <label for="topic7">Technology</label><br>
                                                        <span class="msg"><p id="topic_error"></p></span>
                                                    </div>
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
                                <div class="text-muted">Copyright &copy; Hello World 2021</div>
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
