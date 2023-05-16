<!DOCTYPE html>
<html lang="en">
<head>
    <!-- fontawsome -->
    <script src="https://kit.fontawesome.com/53918a8daa.js" crossorigin="anonymous"></script>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" type="text/css" href="public/css/style.css">
</head>
<body>
    <div class="login-logo-container">
        <div class="login-logo">
            <img src="public/assets/svg/logo.svg">
        </div>
        <form method="POST" action="/register">
            <div class="login-container">
                <div class="message">
                    <?php if (isset($messages)) {
                        foreach ($messages as $message) {
                            echo @$message;
                        }
                    }
                    ?>
                </div>
                <div class="login-icon-and-input">
                    <input class="login-input" name="login" type="text" placeholder="login">
                    <i class="fa-solid fa-user"></i>
                </div>
                <div class="login-icon-and-input">
                    <input class="login-input" name="email" type="text" placeholder="your@email.com">
                    <i class="fa-solid fa-envelope-open"></i>
                </div>
                <div class="login-icon-and-input">
                    <input class="login-input" name="confirmedEmail" type="text" placeholder="repeatYour@email.com">
                    <i class="fa fa-envelope icon"></i>
                </div>
                <div class="login-icon-and-input">
                    <input class="login-input" name="password" type="password" placeholder="password">
                    <i class="fa-solid fa-lock-open"></i>
                </div>
                <div class="login-icon-and-input">
                    <input class="login-input" name="confirmedPassword" type="password" placeholder="repeatPassword">
                    <i class="fa fa-lock icon"></i>
                </div>
                <button type="submit" class="login-button">REGISTER</button>
                <p>if you already have an account</p><a href="/">Login</a>
            </div>
        </form>
    </div>
</body>
</html>