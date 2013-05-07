<?php

if (isset($_SESSION["login"])) {
    header("Location: index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    mysql_connect("$DB_USERS_HOST", "$DB_USERS_USER", "$DB_USERS_PASSWORD") or die ("cannot connect");
    mysql_select_db("$DB_USERS_NAME") or die ("cannot select DB");

    $login = $_POST['login'];
    $password = $_POST['password'];

    $login = stripslashes($login);
    $password = stripslashes($password);
    $login = mysql_real_escape_string($login);
    $password = mysql_real_escape_string($password);
    $sql = "SELECT * FROM $DB_USERS_TABLE WHERE login='$login' or email='$login' and password=SHA1('$password')";
    $result = mysql_query($sql);

    $count = mysql_num_rows($result);

    if ($count == 1) {
        $user = mysql_fetch_array($result);
        $_SESSION["login"] = $user["login"];
        header("Location: index.php");
        exit;
    } else {
        echoLoginForm(true);
        exit;
    }
} else {
    echoLoginForm(false);
}


function echoLoginForm($hasError = false)
{

    ?>
    <form class="form-signin" name="login" method="post" action="login.php">
        <h2 class="form-signin-heading">Please sign in</h2>
        <?php

        if ($hasError) {
            ?>
            <div class="alert alert-error">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong>Warning!</strong> Wrong login or password.
            </div>
        <?php
        }

        ?>
        <input type="text" name="login" class="input-block-level" placeholder="Email address or login">
        <input type="password" name="password" class="input-block-level" placeholder="Password">
        <label class="checkbox">
            <input type="checkbox" value="remember-me"> Remember me
        </label>
        <button class="btn btn-large btn-primary" type="submit">Sign in</button>
    </form>

<?php
}