<?php
// Include config file
require_once "../includes/mysql-setup.php";
 
// Define variables and initialize with empty values
$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";
 
// when user posts to page:
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // check username: it should not be empty, it should be a string, and it should not be taken.
    if(empty(trim($_POST["username"])) || !is_string($_POST["username"])){
        $username_err = "Please enter a username.";
    } else{
        // prepare sql query
        $sql = "SELECT id FROM users WHERE username = ?";
        if($stmt = mysqli_prepare($link, $sql)){
            // bind username to statement. 
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            $param_username = trim($_POST["username"]);
            
            // execute statement and gather output
            if(mysqli_stmt_execute($stmt)){
                mysqli_stmt_store_result($stmt);
                // if more than 0 results, let the user know the name is taken, otherwise, set the username variable
                if(mysqli_stmt_num_rows($stmt) >= 1){
                    $username_err = "This username is already taken.";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        
        // close statement
        mysqli_stmt_close($stmt);
    }
    
    // check 1st password field: it should not be empty, it should be a string, and it should at least 7 characters.
    if(empty(trim($_POST["password"])) || !is_string($_POST["password"]){
        $password_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST["password"])) < 7){
        $password_err = "Password must have atleast 7 characters.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // check 2nd password field: it should not be empty, it should be a string, and it should match the 1st.
    if(empty(trim($_POST["confirm_password"])) || !is_string($_POST["confirm_password"])){
        $confirm_password_err = "Please confirm password.";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }
    
    // check for errors before adding to db.
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err)){
        
        // prepare sql query
        $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
        if($stmt = mysqli_prepare($link, $sql)){
            // bind variables to the statement
            mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_password);
            // set parameters
            $param_username = $username;
            // create password hash
            $param_password = password_hash($password, PASSWORD_DEFAULT);
            // execute the statement
            if(mysqli_stmt_execute($stmt)){
                // TODO: If user successfully creates account, log them in automatically.
                // for now, redirect to login page
                header("location: auth/login.php");
            } else{
                echo "Something went wrong. Please try again later.";
            }
        }
        // close statement
        mysqli_stmt_close($stmt);
    }
    // close connection
    mysqli_close($link);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Sign Up</title>
</head>
<body>
  <h2>Sign Up</h2>
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <div>
      <label>Username</label>
      <input type="text" name="username" value="<?php echo $username; ?>">
      <span><?php echo $username_err; ?></span>
    </div>    
    <div>
      <label>Password</label>
      <input type="password" name="password" value="<?php echo $password; ?>">
      <span><?php echo $password_err; ?></span>
    </div>
    <div>
      <label>Confirm Password</label>
      <input type="password" name="confirm_password" value="<?php echo $confirm_password; ?>">
      <span><?php echo $confirm_password_err; ?></span>
    </div>
    <div>
      <input type="submit" value="Submit">
    </div>
    <p>Already have an account? <a href="auth/login.php">Login here.</a></p>
  </form>
</body>
</html>
