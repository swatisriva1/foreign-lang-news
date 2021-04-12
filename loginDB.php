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
?>