<?php
    include("../../conn.php");

    // $hash = password_hash("jimmy123", PASSWORD_DEFAULT);
    // $sql = "UPDATE users SET password = '$hash' WHERE user_id = 'U004'";
    // mysqli_query($conn, $sql);

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $userID = $_POST["txtUserID"];
        $password = $_POST["txtPassword"];

        $sql = "SELECT user_id, name, role, password, account_status FROM users
                WHERE user_id = '$userID'";
        $result = mysqli_query($conn, $sql);

        if(mysqli_num_rows($result) === 1){
            $row = mysqli_fetch_assoc($result);
            $hash_password = $row["password"];
            $account_status = $row["account_status"];

            if(password_verify($password, $hash_password) && $account_status === "Active") {
                session_start();

                include("../../backend/unsetRegisterData.php");

                $_SESSION["userID"] = $row["user_id"];
                $_SESSION["userName"] = $row["name"];
                $_SESSION["role"] = $row["role"];

                header("Location: ../../backend/loginRedirect.php");
                exit;
            }
            elseif ($account_status === "Inactive") {
                echo "<script>
                        alert('This Account has been Suspended');
                        window.location.href = 'login.php';
                      </script>";
            }
            else {
                echo "<script> 
                        alert('Incorrect Password');
                        window.location.href = 'login.php';
                      </script>";
            }
        } 
        mysqli_close($conn);
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login</title>
        
        <link rel="stylesheet" href="../../styles/guest.css">
        <!-- style & ico -->
        <link rel="icon" href="../../src/elements/logo_vertical.png" type="image/x-icon">

        <!-- icon  -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

        <style>
            #login {
                color: #707c68;
                font-weight: bold;
            }
        </style>
    </head>
    <body>
        <?php include("header.php") ?>
        <main class="login">
            <div class="login-container">
                <div class="login-header">
                    <h1>Welcome Back!</h1>
                    <p>Enter your credentials to continue</p>
                </div>

                <div class="login-form">
                    <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="POST">
                        <table class="login-form-table">
                            <tr>
                                <td class="label"><label for="userID">User ID</label></td>
                                <td class="colon">:</td>
                                <td><input type="text" name="txtUserID" id="userID" required></td>
                            </tr>

                            <tr>
                                <td class="label password-labelText"><label for="password">Password</label></td>
                                <td class="colon password-colon">:</td>
                                <td class="password-feild">
                                    <input type="password" name="txtPassword" id="password" required>
                                    <a href="forgetPasswordPage1.php" class="forgot-password">Forgot Password?</a>
                                </td>
                            </tr>
                        </table>

                        <input type="submit" value="Login" class="btn-login" name="btnLogin">

                        <p class="signup-text">
                            Don't have an account? <a href="registerPage1.php">Sign Up</a>
                        </p>
                    </form>
                </div>
            </div>
        </main>

        <!-- <?php include("footer.php") ?> -->
    </body>
</html>