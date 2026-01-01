<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login Page</title>
        
        <link rel="stylesheet" href="../../styles/guest.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    </head>
    <body>
        <!-- <?php include("header.php") ?> -->
        <main class="login">
            <div class="login-container">
                <div class="login-header">
                    <h1>Welcome Back!</h1>
                    <p>Enter your credentials to continue</p>
                </div>

                <div class="login-form">
                    <form action="../../pages/guest/login.php" method="GET">
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
                                    <a href="#" class="forgot-password">Forgot Password?</a>
                                </td>
                            </tr>
                        </table>

                        <input type="submit" value="Login" class="btn-login" name="btnLogin">

                        <p class="signup-text">
                            Don't have an account? <a href="#">Sign Up</a>
                        </p>
                    </form>
                </div>
            </div>
        </main>

        <!-- <?php include("footer.php") ?> -->
    </body>
</html>