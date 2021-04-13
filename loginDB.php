<?php
require("connectDB.php");

function checkUserCredentials($username, $pwd){
    global $db;
    $isValid = false;
    $query = "SELECT * FROM user_info
    WHERE username = :username";
    $statement = $db->prepare($query);
    $statement->bindValue(':username',$username);
    $statement->execute();
    $user_result=$statement->fetch();
    if(!empty($user_result)) {
        //pwd check
        $pwd_result = $user_result['password'];
        $isValid = password_verify($pwd, $pwd_result);
        // use this if verify function doesn't work (due to old PHP version)
        // $isValid = md5($pwd) == $pwd_result;
    }
    $statement -> closeCursor();
    return $isValid;
}

function getUserFname($username) {
    global $db;
    $Fname = "";
    $query = "SELECT * FROM user_info
    WHERE username = :username";
    $statement = $db->prepare($query);
    $statement->bindValue(':username',$username);
    $statement->execute();
    $user_result=$statement->fetch();
    if(!empty($user_result)) {
        $Fname = $user_result['f_name'];
    }
    $statement -> closeCursor();
    return $Fname;
}

function getLoginCount($username) {
    global $db;
    $login_cnt = null;
    $query = "SELECT * FROM user_info
    WHERE username = :username";
    $statement = $db->prepare($query);
    $statement->bindValue(':username',$username);
    $statement->execute();
    $user_result=$statement->fetch();
    if(!empty($user_result)) {
        $login_cnt = $user_result['login_count'];
    }
    $statement -> closeCursor();
    return $login_cnt;
}

function incLoginCount($username) {
    global $db;
    $query = "UPDATE user_info
                SET login_count = login_count + 1
                WHERE username = :username";
    $statement = $db->prepare($query);
    $statement->bindValue(':username',$username);
    $statement->execute();
    $statement -> closeCursor();
}
?>