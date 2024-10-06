<?php

session_start();
var_dump($_POST); // Check if form data is posted
    
include("connection.php");
include("functions.php");

//checking if user clicked submit and CSRF
if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['token']) /*&& validateToken($_POST['token']*/){
    //something was posted
    $userEmail = $_POST['userEmail'];
    $userPassword = $_POST['userPassword'];
    
    if(!empty($userEmail) && !empty($userPassword) /*&& !is_numeric($userEmail)*/)
    {
        //prepare
        $sqlQuery = $con->prepare( "SELECT * from Users where userEmail = ? limit 1");
        //bind
        $sqlQuery->bind_param("s", $userEmail);

        if ($sqlQuery->execute()) {
            $result = $sqlQuery->get_result();
            if ($result) {
                $user_data = $result->fetch_assoc(); //fetch data as associative array
                if ($user_data) {
                    //now user_data is an array and you can access its componenets like $user_data ['userPassword']
                    if (password_verify($_POST['userPassword'], $user_data['userPassword'])) {
                        //proceed with login
                        $_SESSION['userID'] = $user_data['userID'];
                        header("Location: home_page.html");
                        die;
                    } else {
                        echo "Incorrect password.";
                    }
                } else {
                    echo "User not found.";
                }
            } else {
                echo "Failed to fetch result.";
            }
        } else {
            echo "Query execution failed: " . $con->error;
        }
    } else {
        echo "Please enter both email and password.";
    }
}
?>          
/*
generateToken();*/

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- displays site properly based on user's device -->
    
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css"
      integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh"
      crossorigin="anonymous"
    />

    <link rel="stylesheet" href="style.css" />
    <script src="external.js"></script>

    <!-- jQuery, Popper.js, and Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js"></script>
    
    <title>Wonder Feed</title>
  </head>

    <body>
        <div class = "container">
            <div class = "row">
                <div class = "col">
                    <h1 class="text-center display-1">Welcome to Wonder!</h1>
                </div>         
            </div>
        </div>
        <div class = "container">
            <div class = "row p-3 ">
                <div class ="col-6 border-right border-dark">
                    <h2 class="text-center display-4">Log in</h2>
                    <form action="login.php" method="POST">
                        <div class="form-group">
                            <label for="userEmail" required>Email Address</label>
                            <input name="userEmail" type="email" class="form-control" aria-describedby="emailHelp">
                        </div>
                        <div class="form-group">
                            <label for="userPassword">Password</label>
                            <input name="userPassword" type="password" class="form-control">
                        </div>
                        <button type="submit" class="btn btn-primary">Log in</button>
                    </form>
                </div>
                <div class = "col-6 m-auto">
                    <h2 class="text-center display-4">Sign up</h2>
                    <form>
                        <div class="form-group">
                            <label for="userFirstName" required>First Name</label>
                            <input type="text" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="userLastName" required>Last Name</label>
                            <input type="text" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="userEmail" required>Email Address</label>
                            <input type="email" class="form-control" aria-describedby="emailHelp">
                        </div>
                        <div class="form-group">
                            <label for="userPassword">Create Password</label>
                            <input type="password" class="form-control">
                        </div>
                        <button type="submit" class="btn btn-primary">Sign up </button>
                    </form>
                </div>
            </div>  
        </div>
    </body>
</html>

