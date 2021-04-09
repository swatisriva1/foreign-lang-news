<?php 
    require("env.php");
    include "vendor/autoload.php";
                        
    use jcobhams\NewsApi\NewsApi;
    
    $api_key = getenv("api_key");

    $newsapi = new NewsApi($api_key);

    class Article {
        // Properties
        public $source_name;
        public $title;
        public $description;
        public $url;
        public $image;
        public $date;

        function __construct($source_name, $title, $description, $url, $image, $date) {
            $this->source_name = $source_name;
            $this->title = $title;
            $this->description = $description;
            $this->url = $url;
            $this->image = $image;
            $this->date = $date;
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <title>Home - Foreign Language News Aggregator</title> 
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
            <a class="navbar-brand" href="index.html">Foreign Language News Aggregator</a>
            <!-- Navbar Search-->
            <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
                <div class="input-group">
                    <input class="form-control" type="text" placeholder="Search" aria-label="Search" aria-describedby="basic-addon2" />
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
                        <a class="dropdown-item" href="settings.html">Settings</a>
                        <a class="dropdown-item" href="#">Activity Log</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="landing.html">Logout</a>
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

                    // retrieve a list of languages for that user
                    // retrieve a list of topics for that user

                    $q = null;
                    $sources = null;
                    $country = "kr";
                    $category = null;
                    $page_size = 4;
                    $page = null;
            
                    $top_headlines = $newsapi->getTopHeadlines($q, $sources, $country, $category, $page_size, $page);
                    
                    // echo "Headlines: <br/>";

                    $list_articles = array();

                    // Make list of top 4 articles
                    foreach ($top_headlines->articles as $article) {
                        $list_articles[] = new Article($article->source->name, $article->title, $article->description, $article->url, $article->urlToImage, $article->publishedAt);
                    }

                    // foreach ($list_articles as $article) {
                    //     echo "$article->source_name : $article->date <br/>";
                    // }
                    
                ?>
                <main>
                    <div class="container-fluid">
                        <h1 class="mt-4">Top Stories</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Spanish</li>
                            <!-- <button style="display: flex; margin-left: 1000px;" class="btn btn-primary" type="button">See More</button> -->
                        </ol>
                        <div class="row">
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-primary text-white mb-4">
                                    <div class="card-body">La escasez de diésel paraliza una vez más a Venezuela</div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <!-- learned about target and rel attribute here: https://www.freecodecamp.org/news/how-to-use-html-to-open-link-in-new-tab/ -->
                                        <a class="small text-white stretched-link" href="https://elpais.com/internacional/2021-03-13/la-escasez-de-diesel-paraliza-una-vez-mas-a-venezuela.html" target="_blank" rel="noopener noreferrer">Read More</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-warning text-white mb-4">
                                    <div class="card-body">Hazard vuelve a caer y no jugará contra el Atalanta</div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="https://www.elmundo.es/deportes/futbol/champions-league/2021/03/15/604f3a2afc6c837c2c8b463e.html" target="_blank" rel="noopener noreferrer">Read More</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-success text-white mb-4">
                                    <div class="card-body">La 63ª entrega de los premios Grammy, en imágenes 14 fotos</div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="https://elpais.com/elpais/2021/03/15/album/1615777382_203475.html" target="_blank" rel="noopener noreferrer" target="_blank" rel="noopener noreferrer">Read More</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-danger text-white mb-4">
                                    <div class="card-body">Cinco grandes enigmas del coronavirus aún por resolver</div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="https://elpais.com/ciencia/2021-03-13/cinco-grandes-enigmas-del-coronavirus-aun-por-resolver.html" target="_blank" rel="noopener noreferrer">Read More</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Italian</li>
                            <!-- <button style="margin-left: 1015px;" class="btn btn-primary" type="button">See More</button> -->
                        </ol>
                        <div class="row">
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-primary text-white mb-4">
                                    <div class="card-body">Real Madrid, Zidane apre al ritorno di Ronaldo: "Può darsi"</div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="https://www.repubblica.it/sport/calcio/champions/2021/03/15/news/zidane_carica_il_real_con_l_atalanta_e_come_una_finale_ritorna_cr7_puo_darsi_-292346264/" target="_blank" rel="noopener noreferrer">Read More</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-warning text-white mb-4">
                                    <div class="card-body">Ginevra Bompiani: "Si traduce la lingua non il colore"</div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="https://rep.repubblica.it/pwa/robinson/2021/03/14/news/amanda_gorman_ginevra_bompiani_traduttore_identita_-292240255/" target="_blank" rel="noopener noreferrer">Read More</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-success text-white mb-4">
                                    <div class="card-body">Scuola, da lunedì a casa 7 milioni di studenti</div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="https://www.repubblica.it/cronaca/2021/03/14/news/scuola_da_lunedi_7_milioni_di_studenti_a_casa-292158643/" target="_blank" rel="noopener noreferrer">Read More</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-danger text-white mb-4">
                                    <div class="card-body">Giulietta e le altre ragazze di Skakespeare in love</div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="https://www.repubblica.it/cultura/2021/03/08/news/giulietta_e_le_altre_ragazze_si_skakespeare_in_love-291083786/" target="_blank" rel="noopener noreferrer">Read More</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Korean</li>
                            <!-- <button style="margin-left: 1005px;" class="btn btn-primary" type="button">See More</button> -->
                        </ol>
                        <div class="row">
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-primary text-white mb-4">
                                    <div class="card-body">
                                        <p><?php echo $list_articles[0]->source_name ?></p>
                                        <img src="<?php echo $list_articles[0]->image ?>" style="width: 100%; height: auto;">
                                        <h3><?php echo $list_articles[0]->title ?></h3>
                                        <p><?php echo $list_articles[0]->date ?></p>
                                        <p><?php echo $list_articles[0]->description ?></p>
                                    </div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="<?php echo $list_articles[0]->url ?>" target="_blank" rel="noopener noreferrer">Read More</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-warning text-white mb-4">
                                    <div class="card-body">
                                        <p><?php echo $list_articles[1]->source_name ?></p>
                                        <img src="<?php echo $list_articles[1]->image ?>" style="width: 100%; height: auto;">
                                        <h3><?php echo $list_articles[1]->title ?></h3>
                                        <p><?php echo $list_articles[1]->date ?></p>
                                        <p><?php echo $list_articles[1]->description ?></p>
                                    </div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="<?php echo $list_articles[1]->url ?>" target="_blank" rel="noopener noreferrer">Read More</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-success text-white mb-4">
                                    <div class="card-body">
                                        <p><?php echo $list_articles[2]->source_name ?></p>
                                        <img src="<?php echo $list_articles[2]->image ?>" style="width: 100%; height: auto;">
                                        <h3><?php echo $list_articles[2]->title ?></h3>
                                        <p><?php echo $list_articles[2]->date ?></p>
                                        <p><?php echo $list_articles[2]->description ?></p>
                                    </div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="<?php echo $list_articles[2]->url ?>" target="_blank" rel="noopener noreferrer">Read More</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-danger text-white mb-4">
                                    <div class="card-body">
                                        <p><?php echo $list_articles[3]->source_name ?></p>
                                        <img src="<?php echo $list_articles[3]->image ?>" style="width: 100%; height: auto;">
                                        <h3><?php echo $list_articles[3]->title ?></h3>
                                        <p><?php echo $list_articles[3]->date ?></p>
                                        <p><?php echo $list_articles[3]->description ?></p>
                                    </div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="<?php echo $list_articles[3]->url ?>" target="_blank" rel="noopener noreferrer">Read More</a>
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
        <!-- <script src="js/home.js"></script> -->
        <script src="js/common.js"></script>
    </body>
</html>