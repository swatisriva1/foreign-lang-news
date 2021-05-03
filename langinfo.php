<?php                     
    use jcobhams\NewsApi\NewsApi;
    require("homeDB.php");
    require("langinfoDB.php");
    session_start();

    $api_key = getenv("api_key");

    $newsapi = new NewsApi($api_key);

    if(!$_SESSION['loggedInFNA'] || !isset($_COOKIE['user'])) {
      header("Location: landing.php");
    }

    if ($_SESSION['user']){
        $username = $_SESSION['user'];
    }
    else {
        header("Location: landing.php");    
    }

    if($_SERVER['REQUEST_METHOD'] == 'GET')
    {
        if(!empty($_GET['action']) && ($_GET['action']=='Logout')) {
            session_unset();
            session_destroy();
            setcookie("user", "", time()-3600, "/");
            header("Location:landing.php");
        }
    }

    $languages = getUserLanguages($username);
    $topics = getUserTopics($username);
    // if(!empty($languages)) {
    //     $lang1 = getArticles($languages[0]);
    //     $lang2 = getArticles($languages[1]);
    //     $lang3 = getArticles($languages[2]);
    // }
    // else header("Location: firstprefs.php");
    if(empty($topics)) {
        echo header("Location: firstprefs.php");
    }

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <title>Language Information - Hello World</title> 
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="Display language facts" />
        <meta name="author" content="Megan Reddy (mr8vn) and Swati Srivastava (ss3ck)" />
        <link href="css/stylesheet.css" rel="stylesheet" />
        <link href="css/common.css" rel="stylesheet" />
        <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>

        <style>
            .breadcrumb-item {
                font-size: 20px;
                font-weight: bold;
            }
            .center {
                display: block;
                margin-left: auto;
                margin-right: auto;
                width: 50%;
            }
            img {
                max-width: 100%;
                max-height: 100%;
            }
            @media only screen and (max-width: 768px) {
                .breadcrumb-item {
                    font-size: 1rem;
                    font-weight: bold;
                }
            }
        </style>
        
    </head>
    <body class="sb-nav-fixed">
        <!-- <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark"> -->
        <nav class="sb-topnav navbar navbar-expand navbar-dark">
            <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button>
            <a style="font-size: 30px;" class="navbar-brand" href="home.php">Hello World</a>
            <!-- Navbar Search-->
            <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
                <!-- <div class="input-group">
                    <input class="form-control" type="text" placeholder="Search" aria-label="Search" aria-describedby="basic-addon2" />
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
                                <?php echo idToLang($languages[0]) ?>
                            </a>
                            <a class="nav-link" id="menu-label" href="home.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-globe"></i></div>
                                <?php echo idToLang($languages[1]) ?>
                            </a>
                            <a class="nav-link" id="menu-label" href="home.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-globe"></i></div>
                                <?php echo idToLang($languages[2]) ?>
                            </a>
                            <div class="sb-sidenav-menu-heading">Topics</div>
                            <a class="nav-link" id="menu-label" href="home.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-bookmark"></i></div>
                                <?php echo idToTopic($topics[0]) ?>
                            </a>
                            <a class="nav-link" id="menu-label" href="home.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-bookmark"></i></div>
                                <?php echo idToTopic($topics[1]) ?>
                            </a>
                            <a class="nav-link" id="menu-label" href="home.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-bookmark"></i></div>
                                <?php echo idToTopic($topics[2]) ?>
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
            <!-- Table section -->
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid">
                        <h1 class="mt-4">Language Information</h1>
                        <br>
                        <form>
                            <select id="lang-dropdown" name="languages" onchange="showLanguage(this.value)">
                                <option value="">Select a language:</option>
                                <option value="fr">French</option>
                                <option value="de">German</option>
                                <option value="it">Italian</option>
                                <option value="kr">Korean</option>
                                <option value="jp">Japanese</option>
                                <option value="cn">Chinese</option>
                                <option value="nl">Dutch</option>
                                <option value="no">Norwegian</option>
                                <option value="pt">Portuguese</option>
                                <option value="ru">Russian</option>
                            </select>
                        </form>

                        <br>
                        <div class="row">
                            <div class="col-xl-6">
                                <div style="height: 300px;" class="card mb-4">
                                    <div class="card-header">
                                        <h4 id="selected-lang">Language Facts</h4>
                                    </div>
                                    <div class="card-body">   
                                        <ul>
                                            <li id="fact1">Select a language to display fact 1.</li>
                                            <li id="fact2">Select a language to display fact 2.</li>
                                            <li id="fact3">Select a language to display fact 3.</li>
                                            <li id="fact4">Select a language to display fact 4.</li>
                                        </ul>  
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div style="height: 300px;" class="card mb-4">
                                    <div class="card-header">
                                        <h4>Country Flag</h4>
                                    </div>
                                    <div class="card-body">    
                                        <img src="images/world-map.jpg" alt="Country Flag" id="flag-img" class="center">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Language facts -->
                        <!-- <br>
                        <h4 id="selected-lang"></h4>
                        <ul>
                            <li id="fact1"></li>
                            <li id="fact2"></li>
                            <li id="fact3"></li>
                            <li id="fact4"></li>
                        </ul>   -->
                            

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
        <script src="js/common.js"></script>
        <script src="js/langinfo.js"></script>
    </body>
</html>
