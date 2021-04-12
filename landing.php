<?php
    //Code adapted from https://www.tutorialrepublic.com/php-tutorial/php-mysql-login-system.php
    require('connectDB.php'); //allow to specify what files to include in file
    require('loginDB.php');

    $login_err = "";

    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
      if(!empty($_POST['action']) && $_POST['action'] == "login") {    
        // header("Location: index.html");
        // echo "hi";
        // echo password_hash("Hello!23", PASSWORD_BCRYPT);   // $2y$10$co0cPNDQ.r.njTpnSs9WFePZeBcz/Ip/ppsu/9xRtCdqwoMZ1MOIS
        $userCred = checkUserCredentials($_POST["inputUsername"], $_POST["inputPassword"]);
        
        if(checkUserCredentials($_POST["inputUsername"], $_POST["inputPassword"])){ 
            session_start();
            $_SESSION['user'] = $_POST["inputUsername"];
            $_SESSION['loggedInFNA'] = true;
            header("Location: home.php");
        }
        else {
            $login_err = "You entered an incorrect username or password.";
        }
      }
    }
?>



<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <title>Foreign Language News Aggregator</title> <!-- name of our app -->
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="View aggregated news in multiple languages" />
        <meta name="author" content="Swati Srivastava (ss3ck)" />
        <link href="css/stylesheet.css" rel="stylesheet" />
        <link href="css/common.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>

        <style>
            #layoutAuthentication {
                /* background-color: #172A3A; */
                background-color: #004346;
                background-image: url('images/globe_background.jpg');
                background-size: cover;
            }
            .overlay {
                /* position: absolute; */
                min-height: 100%;
                min-width: 100%;
                left: 0;
                top: 0;
                background: rgba(200, 244, 244, 0.25);
            }
            #layoutAuthentication_footer {
                /* background-color: #508991; */
                position: relative;
                margin-top: 50px;
                background-color: #172A3A;
            }
            #appHeader {
                color: #eeeeee;
                /* font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif; */
                /* position: relative; */
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                padding-top: 10px;
                text-align: center;
            }
            #login-btn {
                color: #eeeeee;
                background-color: #09BC8A;
                border-color: #09BC8A;
                padding-left: 20px;
                padding-right: 20px;
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            }
            #login-btn:hover:enabled {
                background-color: #508991;
                border-color: #508991;
            }
            /* #sign-up-btn {
                color: #eeeeee;
                background-color: #004346;
                border: none;
                padding: 8px;
                border-radius: 6px;
            }
            #sign-up-btn:hover {
                background-color: #508991;
                border-color: #508991;
            } */
            div.card {
                background-color: #172a3a;
                /* display: block; */ 
                margin-bottom: 30px;
                /* padding: 10px; */
            }
            .container {
                justify-content: center;
            }
            .error_message {
                color: rgb(184, 20, 20); 
                /* font-style:italic;  */
                font-weight: bold;
                text-align: center;
                display: block;
                padding: 10px;
            }
            /* .text-muted {
                color: #eeeeee !important;
            }  */
        </style>

    </head>
    <body class="bg-primary">
        <div id="layoutAuthentication">
            <div class="overlay">
                <div id="layoutAuthentication_content">
                    <main>
                        <div id="appHeader">
                            <h1 id="appTitle">Foreign Language News Aggregator</h1>
                            <h2 id="appSlogan">Be a global citizen</h2>
                        </div>
                        <!-- Login card-->
                        <div class="container">
                            <div class="row justify-content-center">
                                <div class="col-lg-5">
                                    <div class="card shadow-lg border-0 rounded-lg mt-5">
                                        <div class="card-header"><h3 style="color: #eeeeee" class="text-center font-weight-light my-4">Login</h3></div>
                                        <div class="card-body">
                                            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" class="login">
                                                <div class="form-group">
                                                    <label style="color: #eeeeee" class="small mb-1" for="inputUsername">Username</label>
                                                    <input class="form-control py-4" id="inputUsername" name="inputUsername" 
                                                        type="text" placeholder="Enter username" autofocus
                                                        value="<?php if(isset($_POST['inputUsername'])) echo $_POST['inputUsername']; ?>"/>
                                                </div>
                                                <div class="form-group">
                                                    <label style="color: #eeeeee" class="small mb-1" for="inputPassword">Password</label>
                                                    <input class="form-control py-4" id="inputPassword" name="inputPassword" type="password" 
                                                        placeholder="Enter password"/> 
                                                </div>
                                                <div class="form-group d-flex align-items-center justify-content-between mt-4 mb-0">
                                                    <button class="btn btn-primary" id="login-btn" type="submit" name="action" value="login">Login</button>
                                                </div>
                                                <span class="error_message"><?php if(!empty($login_err)) echo $login_err; ?></span>
                                            </form>
                                        </div>
                                        <div class="card-footer text-center">
                                            <div class="small">
                                                <!--<a href="register.html">Need an account? Sign up!</a>-->
                                                <button id="sign-up-btn" name="sign-up">Need an account? Sign up</button> 
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </main>
                </div>
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
        <script src="js/landing.js"></script>
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    </body>
</html>
