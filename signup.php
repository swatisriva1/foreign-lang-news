<?php
    require('connectDB.php'); //allow to specify what files to include in file
    require('signupDB.php');

    $unique_err = $create_success = $create_fail = "";

    // taken from https://www.w3schools.com/php/php_form_validation.asp
    function cleanInput($input) {
        $input = trim($input);
        $input = stripslashes($input);
        $input = htmlspecialchars($input);
        return $input;
    }

    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        if(isset($_POST["inputUsername"])) {
            $uniqueUser = checkUniqueUsername($_POST["inputUsername"]);
            if(!$uniqueUser) $unique_err = "Username " . $_POST["inputUsername"] . " is taken, please try another.";
            else cleanInput($_POST["inputUsername"]);
        }
        if(isset($_POST["inputFname"])) {
            cleanInput($_POST["inputFname"]);
        }
        if(isset($_POST["inputLname"])) {
            cleanInput($_POST["inputLname"]);
        }
        if(isset($_POST["inputEmailAddress"])) {
            cleanInput($_POST["inputEmailAddress"]);
        }
        if(isset($_POST["inputEmailAddress"])) {
            cleanInput($_POST["inputEmailAddress"]);
        }

        if(empty($unique_err)) {
            // cleanInput($_POST["inputUsername"]);

            // if(isset($_POST["inputFname"])) {
            //     cleanInput($_POST["inputFname"]);
            // }
            // if(isset($_POST["inputLname"])) {
            //     cleanInput($_POST["inputLname"]);
            // }
            // if(isset($_POST["inputEmailAddress"])) {
            //     cleanInput($_POST["inputEmailAddress"]);
            // }
            // if(isset($_POST["inputEmailAddress"])) {
            //     cleanInput($_POST["inputEmailAddress"]);
            // }
            $create_result = addNewUser($_POST['inputUsername'], $_POST['inputPassword'], $_POST['inputFname'], 
                    $_POST['inputLname'], $_POST['inputEmailAddress']);
            // header("Location: log_in.php");
            // echo "Thanks for signing up! Please log in.";
            if($create_result) {
                header("Refresh:3; url=landing.php");
                $create_success = "Thanks for signing up! You will now be redirected to login.";
            }
            else $create_fail = "Something went wrong. Please try again later.";

        }

    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <title>Sign Up - Hello World</title> <!-- name of our app -->
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="Allow user to create an account" />
        <meta name="author" content="Swati Srivastava (ss3ck)" />
        <link href="css/stylesheet.css" rel="stylesheet" />
        <link href="css/common.css" rel="stylesheet" />
        <style>
            #layoutAuthentication {
                /* background-color: #172A3A; */
                background-color: #004346;
            }
            #layoutAuthentication_footer {
                /* background-color: #508991; */
                background-color: #172A3A;
            }
            div.card {
                background-color: #74B3CE;
                display: block;
                /* margin: auto; */
            }
            .small.mb-1 {
                color: black;
            }
            #create-btn {
                color: #eeeeee;
                background-color: #09BC8A;
                border-color: #09BC8A;
            }
            #create-btn:hover:enabled {
                background-color: #12aa7f;
                border-color: #12aa7f;
            }
            /* #return-btn {
                color: #eeeeee;
                background-color: #004346;
                border: none;
                padding: 8px;
                border-radius: 6px;
            }
            #return-btn:hover {
                background-color: #508991;
                border-color: #508991;
            } */
            .error_message {
                color: rgb(184, 20, 20); 
                /* font-style:italic;  */
                font-weight: bold;
                /* padding:10px; */
            }
            .success_message {
                color: #0f9138; 
                /* font-style:italic;  */
                font-weight: bold;
                /* padding:10px; */
            }
            /* .text-muted {
                color: #eeeeee !important;
            }  */
        </style>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>
    </head>
    <body class="bg-primary">
        <div id="layoutAuthentication">
            <!-- Sign up form-->
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-7">
                                <div class="card shadow-lg border-0 rounded-lg mt-5" style="margin-bottom: 35px;">
                                    <div class="card-header"><h3 class="text-center font-weight-light my-4">Create Account</h3></div>
                                    <span class="success_message" id="msg_create_success" style="text-align: center; display: block; margin-top: 10px;"><?php if(!empty($create_success)) echo $create_success ?></span>
                                    <span class="error_message" id="msg_create_success" style="text-align: center; display: block; margin-top: 10px;"><?php if(!empty($create_fail)) echo $create_fail ?></span>
                                    <div class="card-body">
                                        <form id="create-act-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
                                            <!-- <div class="form-group">
                                                <label class="small mb-1" for="inputName">Name</label>
                                                <input class="form-control py-4" id="inputName" type="text" placeholder="Enter name" autofocus required/>
                                                <span class="error_message" id="msg_name"></span>
                                            </div> -->
                                            <div class="form-row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="small mb-1" for="inputFname">First Name</label>
                                                        <input class="form-control py-4" id="inputFname" name="inputFname" value="<?php if(isset($_POST["inputFname"])) echo $_POST['inputFname']?>" type="text" placeholder="Enter first name" required />
                                                        <span class="error_message" id="msg_fname"></span>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="small mb-1" for="inputLname">Last Name</label>
                                                        <input class="form-control py-4" id="inputLname" name="inputLname" value="<?php if(isset($_POST["inputLname"])) echo $_POST['inputLname']?>" type="text" placeholder="Enter last name" required/>
                                                        <span class="error_message" id="msg_lname"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="small mb-1" for="inputEmailAddress">Email</label>
                                                <input class="form-control py-4" id="inputEmailAddress" name="inputEmailAddress" value="<?php if(isset($_POST["inputEmailAddress"])) echo $_POST['inputEmailAddress']?>" type="email" aria-describedby="emailHelp" placeholder="Enter email address" required/>
                                                <span class="error_message" id="msg_email"></span>
                                            </div>
                                            <!-- <div class="form-group">
                                                <label class="small mb-1" for="inputPhoneNum">Phone Number</label>
                                                <input class="form-control py-4" id="inputPhoneNum" type="tel" placeholder="Enter phone number" />
                                                <span class="error_message" id="msg_num"></span>
                                            </div> -->
                                            <!-- https://developer.mozilla.org/en-US/docs/Web/HTML/Attributes/pattern -->
                                            <!-- <div class="form-group">
                                                <label class="small mb-1" for="inputPhoneNum">Phone Number</label><br>
                                                <input class="py-2" name="tel1" type="tel" pattern="[0-9]{3}" placeholder="###" aria-label="3-digit area code" size="2" required/> - 
                                                <input class="py-2" name="tel2" type="tel" pattern="[0-9]{3}" placeholder="###" aria-label="3-digit prefix" size="2" required/> -
                                                <input class="py-2" name="tel3" type="tel" pattern="[0-9]{4}" placeholder="####" aria-label="4-digit number" size="3" required/>
                                                <span class="error_message" id="msg_phone"></span>
                                            </div> -->
                                            <div class="form-group">
                                                <label class="small mb-1" for="inputUsername">Username</label>
                                                <input class="form-control py-4" id="inputUsername" name="inputUsername" value="<?php if(isset($_POST["inputUsername"])) echo $_POST['inputUsername']?>" type="text" placeholder="Enter username" required/>
                                                <span class="error_message" id="msg_username"></span><br>
                                                <span class="error_message" id="msg_username_server"><?php if(!empty($unique_err)) echo $unique_err; ?></span>
                                            </div>
                                            <div class="form-row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="small mb-1" for="inputPassword">Password</label>
                                                        <input class="form-control py-4" id="inputPassword" name="inputPassword" value="<?php if(isset($_POST["inputPassword"])) echo $_POST['inputPassword']?>" type="password" placeholder="Enter password" required/>
                                                        <span class="error_message" id="msg_pwd"></span>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="small mb-1" for="inputConfirmPassword">Confirm Password</label>
                                                        <input class="form-control py-4" id="inputConfirmPassword" name="inputConfirmPassword" value="<?php if(isset($_POST["inputConfirmPassword"])) echo $_POST['inputConfirmPassword']?>" type="password" placeholder="Confirm password" required/>
                                                        <span class="error_message" id="msg_confirm_pwd"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- <div class="form-group mt-4 mb-0"><a class="btn btn-primary btn-block" id="create_btn" href="landing.html">Create Account</a></div> -->
                                            <div class="form-group mt-4 mb-0">
                                                <button class="btn btn-light btn-block" id="create-btn" name="create-btn">Create Account</button>
                                                <!-- <span class="error_message" id="msg_submit" style="text-align: center; display: block; margin-top: 10px;"></span> -->
                                            </div>
                                        </form>
                                    </div>
                                    <div class="card-footer text-center">
                                        <div class="small"><a href="landing.php"><button id="return-btn" type="button">Have an account? Go to login</button></a></div>
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
        
        <script src="js/signup.js"></script>
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>      
    </body>
</html>
