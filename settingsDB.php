<?php

require('connectDB.php');

function loadUserInfo($username) {
    // load user info to populate account form fields
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

function getUserFname($username) {
    // retrieve first name of given user

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

function idToLang($lang_id) {
    // convert lang_id to language name

    global $db, $newsapi;

    $query = "SELECT language FROM langs WHERE lang_id = :lang_id";
    $statement = $db->prepare($query);
    $statement->bindValue(':lang_id', $lang_id);
    $statement->execute();
    $language_name = $statement->fetch();
    $statement->closeCursor();

    return $language_name['language'];
}

function idToTopic($topic_id) {
    // convert topic_id to topic name

    global $db, $newsapi;

    $query = "SELECT topic FROM topics WHERE topic_id = :topic_id";
    $statement = $db->prepare($query);
    $statement->bindValue(':topic_id', $topic_id);
    $statement->execute();
    $topic_name = $statement->fetch();
    $statement->closeCursor();

    return $topic_name['topic'];
}

function getUserLanguages($username) {
    // retrieve a list of languages for given user

    global $db, $newsapi;

    $query = "SELECT * FROM user_lang WHERE username = :username";
	
    // get array of all language ids
    $statement = $db->prepare($query);
    $statement->bindValue(':username', $username);
    $statement->execute();
    $user_languages = $statement->fetch();
    $statement->closeCursor();
    
    // make list of ids
    $language_names = array($user_languages['lang_1'], $user_languages['lang_2'], $user_languages['lang_3']);

    return $language_names;
}

function getUserTopics($username) {
    // retrieve of list of topics for given user

    global $db, $newsapi;

    $query = "SELECT * FROM user_topic WHERE username = :username";
	
    // get array of all topic ids
    $statement = $db->prepare($query);
    $statement->bindValue(':username', $username);
    $statement->execute();
    $user_topics = $statement->fetch();  
    $statement->closeCursor();
    
    // make list of ids
    $topic_names = array($user_topics['topic_1'], $user_topics['topic_2'], $user_topics['topic_3']);

    return $topic_names;
}

function checkBox($box, $preferences) {
    // determine if box should be checked

    $check = false;
    if (in_array($box, $preferences)) {
        $check = true;
    }

    return $check;
}

function getCheckedBoxes($preferences) {
    // get a list of checked boxes

    $updated_preferences = array();
    foreach ($preferences as $box){ 
        $updated_preferences[] = $box;
    }    

    return $updated_preferences;
}

function saveChanges($fname, $lname, $email, $username, $lang_preferences, $topic_preferences)
{
    // save all changes on the page

	global $db;

	$account_query = "UPDATE user_info
			  SET f_name = :fname,
                  l_name = :lname,
                  email = :email
			  WHERE username = :username";
	
	$statement = $db->prepare($account_query);
    $statement->bindValue(':fname',$fname);
    $statement->bindValue(':lname',$lname);
    $statement->bindValue(':email',$email);
    $statement->bindValue(':username',$username);
	$statement->execute();

    $lang_query = "UPDATE user_lang
                SET lang_1 = :lang_1,
                    lang_2 = :lang_2,
                    lang_3 = :lang_3
                WHERE username = :username";
    $statement = $db->prepare($lang_query);
    $statement->bindValue(':lang_1',$lang_preferences[0]);
    $statement->bindValue(':lang_2',$lang_preferences[1]);
    $statement->bindValue(':lang_3',$lang_preferences[2]);
    $statement->bindValue(':username',$username);
	$statement->execute();

    $topic_query = "UPDATE user_topic
                SET topic_1 = :topic_1,
                    topic_2 = :topic_2,
                    topic_3 = :topic_3
                WHERE username = :username";
    $statement = $db->prepare($topic_query);
    $statement->bindValue(':topic_1',$topic_preferences[0]);
    $statement->bindValue(':topic_2',$topic_preferences[1]);
    $statement->bindValue(':topic_3',$topic_preferences[2]);
    $statement->bindValue(':username',$username);
	$statement->execute();

	$statement->closeCursor();	
	
}

?>