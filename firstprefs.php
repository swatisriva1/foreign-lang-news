<?php
    require("connectDB.php");
    require("firstprefsDB.php");
    require("homeDB.php");
    require("loginDB.php");
    session_start();
 
    // if(!$_SESSION['loggedInFNA']) {
    //   header("Location: landing.php");
    // }

    if(!$_SESSION['loggedInFNA'] || !isset($_COOKIE['user'])) {
        header("Location: landing.php");
    }

    if ($_SESSION['user'] && $_COOKIE['user']){
        $username = $_SESSION['user'];
        $Fname = getUserFname($_COOKIE['user']);
    }
    else {
        header("Location: landing.php");    
    }

    // if user has already marked preferences, don't allow them to visit first prefs page
    $user_langs = getUserLanguages($username);
    $user_topics = getUserTopics($username);
    if(!empty($user_langs) && !empty($user_topics)) {
        header("Location: home.php");
    }

    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
      if(!empty($_POST['action']) && $_POST['action'] == "save") { 
        saveFirstPreferences($username, $_POST['lang'], $_POST['topic']);
        header("Location: home.php");
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
        <meta name="description" content="Allow users to pick preferred languages and topics upon first login" />
        <meta name="author" content="Megan Reddy (mr8vn) and Swati Srivastava (ss3ck)" />
        <link href="css/stylesheet.css" rel="stylesheet" />
        <link href="css/common.css" rel="stylesheet" />
        <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>

        <style>
            body {
                background-color: #004346;
            }
            h1, h3, h4 {
                color: #eeeeee;
            }
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
            #first-prefs-btn {
                color: #eeeeee;
                background-color: #09BC8A;
                border-color: #09BC8A; 
                margin-bottom: 30px;
            }
            #first-prefs-btn:hover:enabled {
                background-color: #12aa7f;
                border-color: #12aa7f;
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
                color: #bf3317;
                font-style: italic;
            }     
            .card {
                background-color: #74B3CE;
                display: block;
            }     
        </style>

    </head>
    <body class="sb-nav-fixed">
        <!-- <nav class="sb-topnav navbar navbar-expand navbar-dark">
            <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button>
            <a class="navbar-brand" href="index.html">Foreign Language News Aggregator</a> -->
            <!-- Navbar Search-->
            <!-- <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
                <div class="input-group">
                    <input class="form-control" type="text" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2" />
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="button"><i class="fas fa-search"></i></button>
                    </div>
                </div>
            </form> -->
            <!-- Navbar-->
            <!-- <ul class="navbar-nav ml-auto ml-md-0">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="userDropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                        <a class="dropdown-item" href="settings.html">Settings</a>
                        <a class="dropdown-item" href="activity.html">Activity Log</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="landing.html">Logout</a>
                    </div>
                </li>
            </ul>
        </nav> -->
        <!-- Side navigation-->
        <!-- <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <h3 style="margin-left: 15px; margin-top: 20px;" class="menu-header">Following</h3>
                            <div class="sb-sidenav-menu-heading">Languages</div>
                            <a class="nav-link" id="menu-label" href="index.html">
                                <div class="sb-nav-link-icon"><i class="fas fa-globe"></i></div>
                                Spanish
                            </a>
                            <a class="nav-link" id="menu-label" href="index.html">
                                <div class="sb-nav-link-icon"><i class="fas fa-globe"></i></div>
                                Italian
                            </a>
                            <a class="nav-link" id="menu-label" href="index.html">
                                <div class="sb-nav-link-icon"><i class="fas fa-globe"></i></div>
                                German
                            </a>
                            <div class="sb-sidenav-menu-heading">Topics</div>
                            <a class="nav-link" id="menu-label" href="index.html">
                                <div class="sb-nav-link-icon"><i class="fas fa-bookmark"></i></div>
                                Entertainment
                            </a>
                            <a class="nav-link" id="menu-label" href="index.html">
                                <div class="sb-nav-link-icon"><i class="fas fa-bookmark"></i></div>
                                Sports
                            </a>
                            <a class="nav-link" id="menu-label" href="index.html">
                                <div class="sb-nav-link-icon"><i class="fas fa-bookmark"></i></div>
                                Technology
                            </a>
                            <div class="sb-sidenav-menu-heading">Newspapers</div>
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
                            </a>
                        </div>
                        <button style="margin-left: 15px; margin-top: 20px; margin-bottom: 20px;" class="btn btn-primary" id="preferences-btn" type="button">Edit Preferences</button> 
                    </div>
                </nav>
            </div> -->
            <!-- Settings/preferences-->
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid">
                        <!-- <img src="images/avatar.jpg" alt="Avatar" class="avatar"> -->
                        <h1 style="text-align: center; margin-bottom: 20px;" class="mt-4">Welcome to Foreign News Aggregator, <?php echo $Fname; ?>!</h1>
                        <h3 style="text-align: center; margin-bottom: 20px;">Mark your preferences here so we can tailor your articles</h3>
                        <h4 style="text-align: center; margin-bottom: 20px;">Select 3 for each</h4>
                        <div class="row justify-content-center">
                            <div class="col-xl-5">
                                <form id="first-prefs-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
                                    <div style="height: 500px;" class="card mb-4">
                                        <div class="card-header">
                                            Preferences
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="column">
                                                    <label for="lang-options" class="pref-label">Languages</label>
                                                    <div id="lang-options">
                                                            <input type="checkbox" class="langbox" id="lang1" name="lang[]" value="fr"/>
                                                            <label for="lang1">French</label><br>
                                                            <input type="checkbox" class="langbox" id="lang2" name="lang[]" value="de"/>
                                                            <label for="lang2">German</label><br>
                                                            <input type="checkbox" class="langbox" id="lang3" name="lang[]" value="it"/>
                                                            <label for="lang3">Italian</label><br>
                                                            <input type="checkbox" class="langbox" id="lang4" name="lang[]" value="kr"/>
                                                            <label for="lang4">Korean</label><br>
                                                            <input type="checkbox" class="langbox" id="lang5" name="lang[]" value="jp"/>
                                                            <label for="lang5">Japanese</label><br>
                                                            <input type="checkbox" class="langbox" id="lang6" name="lang[]" value="cn"/>
                                                            <label for="lang5">Chinese</label><br>
                                                            <input type="checkbox" class="langbox" id="lang7" name="lang[]" value="nl"/>
                                                            <label for="lang5">Dutch</label><br>
                                                            <input type="checkbox" class="langbox" id="lang8" name="lang[]" value="no"/>
                                                            <label for="lang5">Norwegian</label><br>
                                                            <input type="checkbox" class="langbox" id="lang9" name="lang[]" value="pt"/>
                                                            <label for="lang5">Portuguese</label><br>
                                                            <input type="checkbox" class="langbox" id="lang10" name="lang[]" value="ru"/>
                                                            <label for="lang5">Russian</label><br>
                                                            <span class="msg"><p id="lang_error"></p></span>
                                                    </div>
                                                    <!-- <span class="msg"><p id="lang_error"></p></span> -->
                                                </div>
                                                <div class="column">
                                                    <label for="topic-options" class="pref-label">Topics</label>
                                                    <div id="topic-options">
                                                            <label><input type="checkbox" class="topbox" id="topic1" name="topic[]" value="general"/>
                                                            <label for="topic1">General</label><br>
                                                            <label><input type="checkbox" class="topbox" id="topic2" name="topic[]" value="sports"/>
                                                            <label for="topic2">Sports</label><br>
                                                            <label><input type="checkbox" class="topbox" id="topic3" name="topic[]" value="health"/>
                                                            <label for="topic3">Health</label><br>
                                                            <label><input type="checkbox" class="topbox" id="topic4" name="topic[]" value="science"/>
                                                            <label for="topic4">Science</label><br>
                                                            <label><input type="checkbox" class="topbox" id="topic5" name="topic[]" value="business"/>
                                                            <label for="topic5">Business</label><br>
                                                            <label><input type="checkbox" class="topbox" id="topic6" name="topic[]" value="entertainment"/>
                                                            <label for="topic6">Entertainment</label><br>
                                                            <label><input type="checkbox" class="topbox" id="topic7" name="topic[]" value="technology"/>
                                                            <label for="topic7">Technology</label><br>
                                                            <span class="msg"><p id="topic_error"></p></span>
                                                    </div>
                                                    <!-- <span class="msg"><p id="topic_error"></p></span> -->
                                                </div>
                                            </div>
                                        </div>
                                        
                                    </div>
                                    <div class="button-wrapper">
                                        <button class="btn btn-primary" id="first-prefs-btn" name="action" value="save" type="submit">Save Changes</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- <div class="button-wrapper">
                            <button style="background-color: #09BC8A; margin-bottom: 30px;" class="btn btn-primary" id="save-btn" type="button">Save Changes</button>
                        </div> -->
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
        <script src="js/firstprefs.js"></script>
        <!-- <script src="js/common.js"></script> -->
    </body>
</html>