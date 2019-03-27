<?php 
require_once "../includes/mysql_setup.php";

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
                        header('Location: ../../');
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
<span><?php echo (isset($_SESSION["logged_in"]) ? 'You are logged in' : 'You are not logged in'); ?></span>
<html lang="en">
    <head>
        <title>Login</title>
    </head>
    <body>
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
    </body>
</html>