<?php                     
    use jcobhams\NewsApi\NewsApi;
    require("homeDB.php");
    require("loginDB.php");
    session_start();

    $api_key = getenv("api_key");

    $newsapi = new NewsApi($api_key);

    // $possible_languages = $newsapi->getLanguages();

    // $possible_countries = $newsapi->getCountries();

    // !!! remove once connected to login
    // $_SESSION['loggedInFNA'] = true;
    // $_SESSION['user'] = 'jdoe27';

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
    // $lang1 = getArticles($languages[0]);
    // $lang2 = getArticles($languages[1]);
    // $lang3 = getArticles($languages[2]);
    if(!empty($languages)) {
        $lang1 = getArticles($languages[0]);
        $lang2 = getArticles($languages[1]);
        $lang3 = getArticles($languages[2]);
    }
    else header("Location: firstprefs.php");
    if(empty($topics)) {
        echo header("Location: firstprefs.php");
    }


?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <title>Home - Hello World</title> 
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="View aggregated news in multiple languages" />
        <meta name="author" content="Megan Reddy (mr8vn)" />
        <link href="css/stylesheet.css" rel="stylesheet" />
        <link href="css/common.css" rel="stylesheet" />
        <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>

        <style>
            .breadcrumb-item {
                font-size: 20px;
                font-weight: bold;
            }
            .card {
                background-color: #3e6486 !important;
                /* height: 800px; */
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
            <a class="navbar-brand" href="home.php">Hello World</a>
            <!-- Navbar Search-->
            <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
                <div class="input-group">
                    <input class="form-control" type="text" placeholder="Search" aria-label="Search" aria-describedby="basic-addon2" />
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="button"><i class="fas fa-search"></i></button>
                    </div>
                </div>
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
                        <!-- <a class="dropdown-item" href="#">Activity Log</a> -->
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
            <!-- News section-->
            <div id="layoutSidenav_content">
                <?php

                    // for testing

                    // var_dump($possible_languages);

                    // var_dump($possible_countries);

                    // foreach ($languages as $language) {
                    //     echo $language;
                    // };

                    // foreach ($topics as $topic) {
                    //     echo $topic;
                    // };
                    
                ?>
                <main>
                    <div class="container-fluid">
                        <h1 class="mt-4">Top Stories</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active"><?php echo idToLang($languages[0]) ?></li>
                            <!-- <button style="display: flex; margin-left: 1000px;" class="btn btn-primary" type="button">See More</button> -->
                        </ol>
                        <div class="row">
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-primary text-white mb-4">
                                    <div class="card-body">
                                        <p><?php echo $lang1[0]->source_name ?></p>
                                        <img src="<?php echo $lang1[0]->image ?>" style="width: 100%; height: auto;">
                                        <h5><?php echo $lang1[0]->title ?></h5>
                                        <p><?php echo $lang1[0]->date ?></p>
                                        <p><?php echo $lang1[0]->description ?></p>
                                    </div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <!-- learned about target and rel attribute here: https://www.freecodecamp.org/news/how-to-use-html-to-open-link-in-new-tab/ -->
                                        <a class="small text-white stretched-link" href="<?php echo $lang1[0]->url ?>" target="_blank" rel="noopener noreferrer">Read More</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-warning text-white mb-4">
                                    <div class="card-body">
                                        <p><?php echo $lang1[1]->source_name ?></p>
                                        <img src="<?php echo $lang1[1]->image ?>" style="width: 100%; height: auto;">
                                        <h5><?php echo $lang1[1]->title ?></h5>
                                        <p><?php echo $lang1[1]->date ?></p>
                                        <p><?php echo $lang1[1]->description ?></p>
                                    </div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="<?php echo $lang1[1]->url ?>" target="_blank" rel="noopener noreferrer">Read More</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-success text-white mb-4">
                                    <div class="card-body">
                                        <p><?php echo $lang1[2]->source_name ?></p>
                                        <img src="<?php echo $lang1[2]->image ?>" style="width: 100%; height: auto;">
                                        <h5><?php echo $lang1[2]->title ?></h5>
                                        <p><?php echo $lang1[2]->date ?></p>
                                        <p><?php echo $lang1[2]->description ?></p>
                                    </div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="<?php echo $lang1[2]->url ?>" target="_blank" rel="noopener noreferrer" target="_blank" rel="noopener noreferrer">Read More</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-danger text-white mb-4">
                                    <div class="card-body">
                                        <p><?php echo $lang1[3]->source_name ?></p>
                                        <img src="<?php echo $lang1[3]->image ?>" style="width: 100%; height: auto;">
                                        <h5><?php echo $lang1[3]->title ?></h5>
                                        <p><?php echo $lang1[3]->date ?></p>
                                        <p><?php echo $lang1[3]->description ?></p>
                                    </div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="<?php echo $lang1[3]->url ?>" target="_blank" rel="noopener noreferrer">Read More</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active"><?php echo idToLang($languages[1]) ?></li>
                            <!-- <button style="margin-left: 1015px;" class="btn btn-primary" type="button">See More</button> -->
                        </ol>
                        <div class="row">
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-primary text-white mb-4">
                                    <div class="card-body">
                                        <p><?php echo $lang2[0]->source_name ?></p>
                                        <img src="<?php echo $lang2[0]->image ?>" style="width: 100%; height: auto;">
                                        <h5><?php echo $lang2[0]->title ?></h5>
                                        <p><?php echo $lang2[0]->date ?></p>
                                        <p><?php echo $lang2[0]->description ?></p>
                                    </div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="<?php echo $lang2[0]->url ?>" target="_blank" rel="noopener noreferrer">Read More</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-warning text-white mb-4">
                                    <div class="card-body">
                                        <p><?php echo $lang2[1]->source_name ?></p>
                                        <img src="<?php echo $lang2[1]->image ?>" style="width: 100%; height: auto;">
                                        <h5><?php echo $lang2[1]->title ?></h5>
                                        <p><?php echo $lang2[1]->date ?></p>
                                        <p><?php echo $lang2[1]->description ?></p>
                                    </div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="<?php echo $lang2[1]->url ?>" target="_blank" rel="noopener noreferrer">Read More</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-success text-white mb-4">
                                    <div class="card-body">
                                        <p><?php echo $lang2[2]->source_name ?></p>
                                        <img src="<?php echo $lang2[2]->image ?>" style="width: 100%; height: auto;">
                                        <h5><?php echo $lang2[2]->title ?></h5>
                                        <p><?php echo $lang2[2]->date ?></p>
                                        <p><?php echo $lang2[2]->description ?></p>
                                    </div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="<?php echo $lang2[2]->url ?>" target="_blank" rel="noopener noreferrer">Read More</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-danger text-white mb-4">
                                    <div class="card-body">
                                        <p><?php echo $lang2[3]->source_name ?></p>
                                        <img src="<?php echo $lang2[3]->image ?>" style="width: 100%; height: auto;">
                                        <h5><?php echo $lang2[3]->title ?></h5>
                                        <p><?php echo $lang2[3]->date ?></p>
                                        <p><?php echo $lang2[3]->description ?></p>
                                    </div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="<?php echo $lang2[3]->url ?>" target="_blank" rel="noopener noreferrer">Read More</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active"><?php echo idToLang($languages[2]) ?></li>
                            <!-- <button style="margin-left: 1005px;" class="btn btn-primary" type="button">See More</button> -->
                        </ol>
                        <div class="row">
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-primary text-white mb-4">
                                    <div class="card-body">
                                        <p><?php echo $lang3[0]->source_name ?></p>
                                        <img src="<?php echo $lang3[0]->image ?>" style="width: 100%; height: auto;">
                                        <h5><?php echo $lang3[0]->title ?></h5>
                                        <p><?php echo $lang3[0]->date ?></p>
                                        <p><?php echo $lang3[0]->description ?></p>
                                    </div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="<?php echo $lang3[0]->url ?>" target="_blank" rel="noopener noreferrer">Read More</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-warning text-white mb-4">
                                    <div class="card-body">
                                        <p><?php echo $lang3[1]->source_name ?></p>
                                        <img src="<?php echo $lang3[1]->image ?>" style="width: 100%; height: auto;">
                                        <h5><?php echo $lang3[1]->title ?></h5>
                                        <p><?php echo $lang3[1]->date ?></p>
                                        <p><?php echo $lang3[1]->description ?></p>
                                    </div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="<?php echo $lang3[1]->url ?>" target="_blank" rel="noopener noreferrer">Read More</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-success text-white mb-4">
                                    <div class="card-body">
                                        <p><?php echo $lang3[2]->source_name ?></p>
                                        <img src="<?php echo $lang3[2]->image ?>" style="width: 100%; height: auto;">
                                        <h5><?php echo $lang3[2]->title ?></h5>
                                        <p><?php echo $lang3[2]->date ?></p>
                                        <p><?php echo $lang3[2]->description ?></p>
                                    </div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="<?php echo $lang3[2]->url ?>" target="_blank" rel="noopener noreferrer">Read More</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-danger text-white mb-4">
                                    <div class="card-body">
                                        <p><?php echo $lang3[3]->source_name ?></p>
                                        <img src="<?php echo $lang3[3]->image ?>" style="width: 100%; height: auto;">
                                        <h5><?php echo $lang3[3]->title ?></h5>
                                        <p><?php echo $lang3[3]->date ?></p>
                                        <p><?php echo $lang3[3]->description ?></p>
                                    </div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="<?php echo $lang3[3]->url ?>" target="_blank" rel="noopener noreferrer">Read More</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>

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
        <!-- <script src="js/home.js"></script> -->
        <script src="js/common.js"></script>
    </body>
</html>
