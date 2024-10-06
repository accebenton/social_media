<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
include("connection.php");
include("functions.php");

// Generate CSRF token on page load
generateToken();

// Check if the form is submitted and the CSRF token is valid
if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['token']) && validateToken($_POST['token'])) {
    // Get user input
    $userEmail = $_POST['userEmail'];
    $userPassword = $_POST['userPassword'];

    // Check if email and password are not empty
    if (!empty($userEmail) && !empty($userPassword)) {
        // Prepare SQL statement
        $sqlQuery = $con->prepare("SELECT * FROM Users WHERE userEmail = ? LIMIT 1");
        $sqlQuery->bind_param("s", $userEmail);
        
        if ($sqlQuery->execute()) {
            $result = $sqlQuery->get_result();
            $user_data = $result->fetch_assoc(); // Fetch data as associative array
            
            // Check if user exists and password matches
            if ($user_data && password_verify($userPassword, $user_data['userPassword'])) {
                // Log in the user
                $_SESSION['userID'] = $user_data['userID'];
                header("Location: home_page.html");
                exit;
            }
        }
    }
}
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
                            <input type="email" name="userEmail" class="form-control" aria-describedby="emailHelp" required>
                        </div>
                        <div class="form-group">
                            <label for="userPassword">Password</label>
                            <input type="password" name="userPassword" class="form-control" required>
                        </div>
                        <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">
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

