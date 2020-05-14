<?php
    include("config/session.php");

    $email = $password = "";
    $message = "";

    if (isset($_POST["submit"])) {
        include("config/establish_db_conn.php");

        $email = mysqli_real_escape_string($conn, $_POST["email"]);
        $password = mysqli_real_escape_string($conn, $_POST["password"]);

        $query_result = mysqli_query($conn, "SELECT * FROM `users` WHERE `email` = '$email';");

        if (mysqli_num_rows($query_result) == 1) {
            $user_data = mysqli_fetch_all(MYSQLI_ASSOC)[0];

            if (password_verify($password, $user_data["password"])) {
                $is_verified = $user_data["is_verified"];
                $email = $user_data["email"];
                $id = $user_data["id"];
                $username = $user_data["username"];
    
                if ($is_verified) {
                    $message = "You have successfully logged in!";

                    session_start();
                    $_SESSION["user_id"] = $id;
                    $_SESSION["username"] = $username;

                    header("Location: index.php");
                    exit();
                } else {
                    $message = "This account has not yet been verified.<br>
                                A verifation email has been sent to $email.";
                }
            } else {
                $message = "Your password is incorrect!";
            }
        } else {
            $message = "Your email is incorrect!";
        }

        mysqli_free_result($query_result);
        mysqli_close($conn);
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include("building_blocks/common_head_tags.php"); ?>
    <title>Log In here!</title>
</head>
<body>
    <?php include("building_blocks/upper_bar.php") ?>
    
    <main class="log-in-section main-user-input-section">
        <form class="log-in-section__form main-form" action="#" method="POST" novalidate>
            <fieldset class="main-form__fieldset">
                <legend class="main-form__legend hidden">Log In Section</legend>
                <input class="log-in-section__email input main-input input" type="email" placeholder="email" name="email">
                <br>
                <br>
                <input class="log-in-section__password input main-input input" type="password" placeholder="password" name="password">
                <?php echo $message; ?>
                <br>
                <br>
                <br>
                <button class="log-in-section__submit-button button main-button" name="submit">
                    <p class="button-text main-button-text">Log In!</p>
                </button>
            </fieldset>
        </form>
    </main>

    <?php include("building_blocks/footer.php") ?>
</body>
</html>
