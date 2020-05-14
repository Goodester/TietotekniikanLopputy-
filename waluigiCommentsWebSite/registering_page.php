<?php
    include("config/establish_db_conn.php");
    include("config/session.php");

    $username = $email = $password = $verification_password = "";
    $errors = ["username" => "", "email" => "", "password" => "", "verification_password" => ""];

    if (isset($_POST["submit"])) {
        
        // Assign user input into variables
        $username = $_POST["username"];
        $email = $_POST["email"];
        $password = $_POST["password"];
        $verification_password = $_POST["verification_password"];

        // Search for duplicates.
        $res_username = mysqli_query($conn, "SELECT * FROM users WHERE username='$username'");
        $res_email = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");

        // check username
        if (empty($_POST["username"])) {
            $errors["username"] = "An username is required!";
        } else if (!preg_match("/^[A-Z0-9_]{3,15}$/i", $_POST["username"])) {
            $errors["username"] = "The username has to be numbers & letters & underscores only and 3-15 characters long!";
        } else if (mysqli_num_rows($res_username) > 0) {
            $errors["username"] = "The username already exists!";
        }

        // check email
		if (empty($_POST["email"])) {
			$errors["email"] = "An email is required!";
		} else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$errors["email"] = "The email must be a valid email address!";
        } else if (mysqli_num_rows($res_email) > 0) {
            $errors["email"] = "The email is already in use!";
        }
        
        // check password
        if (empty($_POST["password"])) {
            $errors["password"] = "A password is required!";
        } else if (strlen($_POST["password"]) < 6) {
            $errors["password"] = "The password has to be more than 5 characters long!";
        }

        // check verification_password
        if (empty($_POST["verification_password"])) {
            $errors["verification_password"] = "A verification password is required!";
        } else if ($verification_password != $password) {
            $errors["verification_password"] = "The passwords don't match!";
        }
        
        if (!array_filter($errors)) {
            $username = mysqli_real_escape_string($conn, $username);
            $email = mysqli_real_escape_string($conn, $email);
            $password = mysqli_real_escape_string($conn, $password);
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            
            $vkey = password_hash(time().$username, PASSWORD_DEFAULT);

            $sql_insert = "INSERT INTO `users` (`username`, `email`, `password`, `vkey`) VALUES ('$username', '$email', '$hashed_password', '$vkey');";

            if (mysqli_query($conn, $sql_insert)) {
                mail(
                    $email, 
                    "Email verification", 
                    "Verify your email by clicking <a href='waluigi-comments.website/verify.php?vkey=$vkey'>this link</a>.", 
                    "From: waluigi@waluigi-comments.website\r\nMIME-Version: 1.0\r\nContent-Type: text/html; charset=UTF-8\r\n"
                );

                header("Location: registration_success.php");
                exit();
            } else {
                echo "query error: " . mysqli_error($conn);
            }

            mysqli_close($conn);
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include("building_blocks/common_head_tags.php"); ?>
    <title>Register here!</title>
</head>
<body>
    <?php include("building_blocks/upper_bar.php") ?>
    
    <main class="register-section main-user-input-section">
        <form class="register-section__form main-form" action="#" method="POST" novalidate>
            <fieldset class="main-form__fieldset">
                <legend class="main-form__legend hidden">Registry Section</legend>
                <input class="register-section__username input main-input input" type="text" 
                       placeholder="username" name="username" value=<?php echo htmlspecialchars($username); ?>>
                <?php echo $errors["username"] ?>
                <br>
                <br>
                <input class="register-section__email input main-input input" type="email" 
                       placeholder="email" name="email" value=<?php echo htmlspecialchars($email); ?>>
                <?php echo $errors["email"] ?>
                <br>
                <br>
                <input class="register-section__password input main-input input" type="password" 
                       placeholder="password" name="password" value=<?php echo htmlspecialchars($password); ?>>
                <?php echo $errors["password"] ?>
                <br>
                <br>
                <input class="register-section__password input main-input input" type="password" 
                       placeholder="repeat the password" name="verification_password" value=<?php echo htmlspecialchars($password); ?>>
                <?php echo $errors["verification_password"] ?>
                <br>
                <br>
                <br>
                <button class="register-section__submit-button button main-button" name="submit"><p class="button-text main-button-text">Register!</p></button>
            </fieldset>
        </form>
    </main>

    <?php include("building_blocks/footer.php") ?>
</body>
</html>
