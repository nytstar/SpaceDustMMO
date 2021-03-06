<<<<<<< HEAD
<?php

require "includes/header.php";

?>

       
    

=======
<?php 
require_once "includes/mysql_setup.php";

// begin session if it isn't started already
session_start();

// if request is a POST
if ($_SERVER["REQUEST_METHOD"] == 'POST') {
    // Both username and password should not be empty, and should be strings.
    if (empty(trim($_POST["username"])) || !is_string($_POST["username"]) || empty(trim($_POST["password"])) || !is_string($_POST["password"])) {
        $auth_err = "Invalid login.";
    } else {
        // prepare sql query
        $sql = "SELECT password, username FROM users WHERE username = ?";
        if ($stmt = mysqli_prepare($link, $sql)) {
            // bind username as a parameter
            mysqli_stmt_bind_param($stmt, 's', $param_username);
            $param_username = $_POST["username"];
            // execute statement
            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_store_result($stmt);
                // check if user exists
                if (mysqli_stmt_num_rows($stmt) == 1) {
                    // get correct password hash from database and username.
                    mysqli_stmt_bind_result($stmt, $correct_pwd_hash, $username);
                    mysqli_stmt_fetch($stmt);
                    if (password_verify($_POST["password"], $correct_pwd_hash)) {
                        // successful login
                        $_SESSION["username"] = $username;
                        $_SESSION["logged_in"] = true;
                    } else {
                        $auth_err = "Invalid login.";
                    }
                } else {
                    $auth_err = "Invalid login.";
                }
            } else {
                $auth_err = "Something weird happened. Try again later.";
            }
        } else {
            $auth_err = "Something weird happened. Try again later.";
        }
        // close statement
        mysqli_stmt_close($stmt);
    }
}
// close connection to db
mysqli_close($link);
?>
<!DOCTYPE html>
<html>
<head>
    <script src="js/index.js" type="text/javascript"></script>
    <link rel="stylesheet" type="text/css" href="css/index.css">
</head>
<body>
<<<<<<< HEAD
>>>>>>> develop



    <h1>Space-Dust</h1>
    
    

  

   

     
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
     
<?php

<<<<<<< HEAD
require "includes/footer.php"

?>
=======
=======
       <nav>
                <ul>
                        <li>
                                <a id="login-trigger" onclick="toggleLogin()" href="#">Log in</a>
                                <div id="login-content" class="<?php echo (isset($auth_err) ? 'active' : ''); ?>">
                                        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                                                <div>
                                                        <label>Username</label>
                                                        <input type="text" name="username">
                                                </div>
                                                <div>
                                                        <label>Password</label>
                                                        <input type="password" name="password">
                                                </div>
                                                <div>
                                                        <input type="submit" value="Login">
                                                </div>
                                                </div>
                                                        <span><?php echo $auth_err; ?></span>
                                                </div>
                                        </form>
                                </div>
                        </li>
                        <li>
                            <a href="auth/register.php">Register</a>
                        </li>
                </ul>
       </nav>
>>>>>>> develop
</body>
</html>
>>>>>>> develop
