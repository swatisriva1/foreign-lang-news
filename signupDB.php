<?php
// Swati Srivastava (ss3ck)

require("connectDB.php");

function checkUniqueUsername($username){
    global $db;
    $isValid = false;
    $query = "SELECT * FROM user_info
    WHERE username = :username";
    $statement=$db->prepare($query);
    $statement->bindValue(':username',$username);
    $statement->execute();
    $user_result=$statement->fetch();
    if(empty($user_result)) {
        $isValid = true;
    }
    $statement->closeCursor();
    return $isValid;
}

function addNewUser($username, $pwd, $f_name, $l_name, $email) {
    global $db;
    $successful_add = false;
    $default_login_count = 0;
    $default_pic_id = 1;
    $query = "INSERT INTO user_info VALUES (:login_count, :username, :password, :pic_id, :fname, :lname, :email)";
    $statement=$db->prepare($query);
    $statement->bindValue(':login_count',$default_login_count);
    $statement->bindValue(':username',$username);
    $hashed_pwd = password_hash($pwd, PASSWORD_BCRYPT);
    // use this if password_hash doesn't work (due to old PHP version)
    // $hashed_pwd = md5($pwd);
    $statement->bindValue(':password',$hashed_pwd);
    $statement->bindValue(':pic_id',$default_pic_id);
    $statement->bindValue(':fname',$f_name);
    $statement->bindValue(':lname',$l_name);
    $statement->bindValue(':email',$email);
    if($statement->execute()) {
        $successful_add = true;
    }
    $statement -> closeCursor();
    return $successful_add;
}

?>