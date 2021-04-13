<?php

require('connectDB.php');

function loadUserInfo($username) {
    global $db, $email, $fname, $lname;

    $query = "SELECT *
			  FROM user_info
			  WHERE username = :username";
	
	$statement = $db->prepare($query);
    $statement->bindValue(':username',$username);
	$statement->execute();
    $result=$statement->fetch();
    if(!empty($result)) {
        $email = $result['email']; 
        $fname = $result['f_name'];
        $lname = $result['l_name'];
    }
	
	$statement->closeCursor();	
}

function getUserLanguages($username) {
    // retrieve a list of languages for given user

    global $db, $newsapi;

    $query = "SELECT lang_id FROM user_lang WHERE username = :username";
	
    // get array of all language ids
    $statement = $db->prepare($query);
    $statement->bindValue(':username', $username);
    $statement->execute();
    $user_languages = $statement->fetchAll();
    $statement->closeCursor();

    $len_lang = count($user_languages);
    
    // make list of ids
    $language_names = array();
    for ($i = 0; $i < 3; $i++) {
        $language_name = $user_languages[$i]['lang_id'];
        $language_names[] = $language_name;
    }

    return $language_names;
}

function getUserTopics($username) {
    // retrieve of list of topics for given user

    global $db, $newsapi;

    $query = "SELECT topic_id FROM user_topic WHERE username = :username";   // change to current user session
	
    // get array of all topic ids
    $statement = $db->prepare($query);
    $statement->bindValue(':username', $username);
    $statement->execute();
    $user_topics = $statement->fetchAll();  
    $statement->closeCursor();
    
    // make list of ids
    $topic_names = array();
    for ($i = 0; $i < 3; $i++) {
        $topic_name = $user_topics[$i]['topic_id'];
        $topic_names[] = $topic_name;
    }

    return $topic_names;
}

function getCheckedBoxes($preferences) {

    $updated_preferences = array();
    foreach ($preferences as $box){ 
        echo $box."<br />";
    }    
}

function saveChanges($fname, $lname, $email, $username)
{
	global $db;

	$query = "UPDATE user_info
			  SET f_name = :fname,
                  l_name = :lname,
                  email = :email
			  WHERE username = :username";
	
	$statement = $db->prepare($query);
    $statement->bindValue(':fname',$fname);
    $statement->bindValue(':lname',$lname);
    $statement->bindValue(':email',$email);
    $statement->bindValue(':username',$username);
	$statement->execute();

	$statement->closeCursor();	
	
}

?>