<?php

// write rest of PHP here

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

?>