<!DOCTYPE html>
<html lang="en">
<head>
    <!-- fontawsome -->
    <script src="https://kit.fontawesome.com/53918a8daa.js" crossorigin="anonymous"></script>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="public/css/style.css">

</head>
<body>
    <div class="login-logo-container">
        <div class="login-logo">
            <img src="public/assets/svg/logo.svg">
        </div>
        <form action="login" method="POST">
            <div class="login-container">
<!--                wyświetlanie serii wiadomości z backend'u-->
                <div class="message">
                    <?php if (isset($messages)) {
                        foreach ($messages as $message) {
                            echo @$message;
                        }
                    }
                    ?>
                </div>
                <!--                dodane dla testu-->
                <div class="login-icon-and-input">
                    <input class="login-input" name="email" type="email" placeholder="your@email.com">
                    <i class="fa fa-envelope icon"></i>
                </div>
                <div class="login-icon-and-input">
                    <input class="login-input" name="password" type="password" placeholder="password">
                    <i class="fa fa-lock icon"></i>
                </div>
                <button type="submit" class="login-button">LOGIN</button>
                <p>you do not have an accout?</p><a href="register">Register</a>
            </div>
        </form>
    </div>
</body>
</html>

