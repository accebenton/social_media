<?php

function InsertNewUser ($con, $userRank, $userName, $userEmail, $userPassword) {

//preapre and bind
$sqlQuery = $con->prepare("insert into Users (userRank, userName, userEmail, userPassword values (?, ?, ?, ?)");
$sqlQuery->bind_param("isss", $userRank, $userName, $userEmail, $userPassword);

$querySuccessful = true;
if (!$sqlQuery->execute()) {
    $querySuccessful = false;
}
$sqlQuery->close();

return $querySuccessful;
}


function SanitiseInput ($input) {

    //remove empty space at beginning and end of string
    $input = trim($input);
    //helps prevent sql injection attacks escaping specific characters
    $input = addslashes ($input);

    return $input;
}


function DisplayAllUsers($con)
{

    //Submit an sql query to the database
$sql = "SELECT userID, userName FROM Users";
$result = $con->query($sql);

    if ($result->num_rows >0) {
        echo "<br>". "We have results!" . "<br>";
        //output data of each row
        while($row = $result->fetch_assoc()) {
            echo "<br> User ID: ". $row["userID"]." - User Name: ". $row["userName"]."<br>";
        }   
    }
    else {
        echo "0 results" . "<br>";
    }
}

function CheckLogin ($con)
{
    if(isset($_SESSION['userID'])) {
        $userID = $_SESSION['userID'];

    //stops searching once found record "limit 1"
    $query = "SELECT * FROM Users WHERE userID = '$userID' LIMIT 1";
    //result of this query stored in results
    $result = mysqli_query($con, $query);
    
        if($result && mysqli_num_rows($result) > 0)
        {
            $user_data = mysqli_fetch_assoc($result);
            return $user_data;
        }
    }

    //redirect to login
    header("Location: login.php");
    die();
}
//checking for Admin
function CheckRankAccess($requiredRank, $user_data)
{
    $userRank = $user_data['userRank'];
    if($userRank <= $requiredRank)
    {
        return true;
    }
    else
    {
        return false;
    }
}

function generateRandomString($length) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
    $max = strlen ($characters) - 1;

    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters [rand (0, $max)];
    }
    return $randomString;
}

function generateToken () {
    $_SESSION['token'] = generateRandomString(20);
}

function validateToken ($formToken){
    if($formToken === $_SESSION['token']){
        return true;
    }
    return false;
}

?>