<?php 

?>

<!DOCTYPE html>
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
                <input type="submit">
            </div>
            </div>
                <span><?php echo $auth_err; ?></span>
            </div>
        </form>
    </body>
</html>