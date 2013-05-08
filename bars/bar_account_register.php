<?php

if (isset($_SESSION["login"])) {
    header("Location: index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    mysql_connect("$DB_USERS_HOST", "$DB_USERS_USER", "$DB_USERS_PASSWORD") or die ("cannot connect");
    mysql_select_db("$DB_USERS_NAME") or die ("cannot select DB");

    $login = mysql_real_escape_string(stripslashes(trim($_POST['login'])));
    $email = mysql_real_escape_string(stripslashes(trim($_POST['email'])));
    $password1 = mysql_real_escape_string(stripslashes(trim($_POST['password1'])));
    $password2 = mysql_real_escape_string(stripslashes(trim($_POST['password2'])));

    if ($login == "" || $email == "" || $password1 == "" || $password2 == "") {
        echoRegisterForm("All fields are required!");
        goto exit_label;
    }

    if ($password1 != $password2) {
        echoRegisterForm("Passwords are not the same!");
        goto exit_label;
    }

    $sql = "SELECT * FROM $DB_USERS_TABLE WHERE login='$login'";
    $result = mysql_query($sql);
    $count = mysql_num_rows($result);
    if ($count > 0) {
        echoRegisterForm("Such login is already registered.");
        goto exit_label;
    }

    $sql = "SELECT * FROM $DB_USERS_TABLE WHERE email='$email'";
    $result = mysql_query($sql);
    $count = mysql_num_rows($result);
    if ($count > 0) {
        echoRegisterForm("Such  email is already registered.");
        goto exit_label;
    }

    $sql = "INSERT INTO $DB_USERS_TABLE (login, email, password) VALUES ('$login', '$email', SHA1('$password1'))";
    $result = mysql_query($sql);

    if (!$result) {
        echoRegisterForm("Can not create new user with a such input data.");
        goto exit_label;
    } else {
        // Login this user at the same time
        $_SESSION["login"] = $login;
        echoSuccessForm("index.php");
        goto exit_label;
    }
} else {
    echoRegisterForm();
}

exit_label:

function echoRegisterForm($errorMessage = "")
{

    ?>
    <div class="row">
        <div class="span6 offset3">
            <div class="well">
                <form class="form-signin" name="login" method="post" action="register.php">
                    <h2 class="form-signin-heading">Registration form</h2>
                    <p>
                        You are going to create a global account for all PixelOwner services.
                    </p>
                    <?php

                    if ($errorMessage != "") {
                        ?>
                        <div class="alert alert-error">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <strong>Warning!</strong> <?php echo $errorMessage; ?>
                        </div>
                    <?php
                    }

                    ?>
                    <input type="text" name="login" class="input-block-level" placeholder="Login" required>
                    <input type="text" name="email" class="input-block-level" placeholder="Email address" required>
                    <input type="password" name="password1" class="input-block-level" placeholder="Password" required>
                    <input type="password" name="password2" class="input-block-level" placeholder="Repeat password" required>
                    <div class="btn-group" style="float: right">
                        <a class="btn btn-mini btn" href="login.php" alt="Register">Already have an account</a>
                    </div>
                    <br />
                    <button class="btn btn-large btn-primary" type="submit">Register</button>
                </form>
            </div>
        </div>
    </div>
<?php
}

function echoSuccessForm($linkToRedirect)
{

    ?>
    <div class="row">
        <div class="span6 offset3">
            <div class="well" style="text-align: center">
                <h2>Successful registration!</h2>
                <p>
                    Now you are registered and signed in.
                </p>
                <br />
                <a class="btn btn-large btn-primary" href="<?php echo $linkToRedirect; ?>" alt="Continue surfing">Continue surfing</a>
            </div>
        </div>
    </div>
<?php
}