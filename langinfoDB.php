<?php
    require("connectDB.php");

    if($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET["selectedLang"])) {
        $response_result = "";

        $lang = getLang($_GET["selectedLang"]);
        $response_result = $response_result . $lang . "\n";
        $fact1 = getLangF1($_GET["selectedLang"]);
        $response_result = $response_result . $fact1 . "\n";
        $fact2 = getLangF2($_GET["selectedLang"]);
        $response_result = $response_result . $fact2 . "\n";
        $fact3 = getLangF3($_GET["selectedLang"]);
        $response_result = $response_result . $fact3 . "\n";
        $fact4 = getLangF4($_GET["selectedLang"]);
        $response_result = $response_result . $fact4 . "\n";
        
        echo $response_result;
    }
    else return null;

    function getLang($lang) {
        global $db;
        $langName = "";
        $query = "SELECT * FROM langs NATURAL JOIN lang_info
                WHERE lang_id = :lang";
        $statement = $db->prepare($query);
        $statement->bindValue(':lang',$lang);
        $statement->execute();
        $user_result=$statement->fetch();
        if(!empty($user_result)) {
            $langName = $user_result['language'];
        }
        $statement -> closeCursor();
        return $langName;
    }

    function getLangF1($lang) {
        global $db;
        $fact1 = "";
        $query = "SELECT * FROM langs NATURAL JOIN lang_info
        WHERE lang_id = :lang";
        $statement = $db->prepare($query);
        $statement->bindValue(':lang',$lang);
        $statement->execute();
        $user_result=$statement->fetch();
        if(!empty($user_result)) {
            $fact1 = $user_result['fact1'];
        }
        $statement -> closeCursor();
        return $fact1;
    }

    function getLangF2($lang) {
        global $db;
        $fact2 = "";
        $query = "SELECT * FROM langs NATURAL JOIN lang_info
        WHERE lang_id = :lang";
        $statement = $db->prepare($query);
        $statement->bindValue(':lang',$lang);
        $statement->execute();
        $user_result=$statement->fetch();
        if(!empty($user_result)) {
            $fact2 = $user_result['fact2'];
        }
        $statement -> closeCursor();
        return $fact2;
    }

    function getLangF3($lang) {
        global $db;
        $fact3 = "";
        $query = "SELECT * FROM langs NATURAL JOIN lang_info
        WHERE lang_id = :lang";
        $statement = $db->prepare($query);
        $statement->bindValue(':lang',$lang);
        $statement->execute();
        $user_result=$statement->fetch();
        if(!empty($user_result)) {
            $fact3 = $user_result['fact3'];
        }
        $statement -> closeCursor();
        return $fact3;
    }

    function getLangF4($lang) {
        global $db;
        $fact4 = "";
        $query = "SELECT * FROM langs NATURAL JOIN lang_info
        WHERE lang_id = :lang";
        $statement = $db->prepare($query);
        $statement->bindValue(':lang',$lang);
        $statement->execute();
        $user_result=$statement->fetch();
        if(!empty($user_result)) {
            $fact4 = $user_result['fact4'];
        }
        $statement -> closeCursor();
        return $fact4;
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

?>