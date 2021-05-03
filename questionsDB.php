<?php
// Megan Reddy (mr8vn)

require("env.php");
require("connectDB.php");
session_start();

// header('Access-Control-Allow-Origin: http://localhost:4200');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: X-Requested-With, Content-Type, Origin, Authorization, Accept, Client-Security-Token, Accept-Encoding');
header('Access-Control-Max-Age: 1000');  
header('Access-Control-Allow-Methods: POST, GET, OPTIONS, DELETE, PUT');

// retrieve data from the request
$postdata = file_get_contents("php://input");

// Process data

// Extract json format to PHP array
$request = json_decode($postdata);

$data = [];
foreach ($request as $k => $v)
{
	$data[0]['post_'.$k] = $v;
}

if (checkDataValid($request, $data)) {

    // prepare and execute query
    $query = "INSERT INTO questions 
            (fname, lname, email, type, qText)
            VALUES (:fname, :lname, :email, :type, :text)
            ON DUPLICATE KEY UPDATE
                fname = :fname,
                lname = :lname,
                email = :email,
                type = :type,
                qtext = :text";
    $statement = $db->prepare($query);
    $statement->bindValue(':fname', $data[0]['post_fname']);
    $statement->bindValue(':lname', $data[0]['post_lname']);
    $statement->bindValue(':email', $data[0]['post_email']);
    $statement->bindValue(':type', $data[0]['post_type']);
    $statement->bindValue(':text', $data[0]['post_qText']);
    $successful = $statement->execute();
    $statement->closeCursor();

    $msg = '';
    if ($successful) {
        $msg = "Your request was submitted.";
    }
    else {
        $msg = "An error occurred. Please try again.";
    }

    // Send response (in json format) back the front end
    echo json_encode($msg);

}


function checkDataValid($request, $data) {
    $isValid = true;
    foreach ($request as $k => $v)
    {
        if(empty($data[0]['post_'.$k])) {
            $isValid = false;
        };
    }

    return $isValid;
}

?>