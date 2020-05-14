<?php
    include("config/session.php");

    $message = "";

    if (isset($_GET["vkey"])) {
        include("config/establish_db_conn.php");

        $vkey = $_GET["vkey"];
        $query_result = mysqli_query($conn, "SELECT `vkey` FROM `users` WHERE `is_verified` = 0 AND `vkey` = '$vkey';");

        if (mysqli_num_rows($query_result) == 1) {
            mysqli_free_result($query_result);
            $update = mysqli_query($conn, "UPDATE `users` SET is_verified = 1 WHERE vkey = '$vkey';");

            if ($update) {
                $message = "Your account has been succesfully verified.";
            } else {
                $message = mysqli_error($query_result);
            }
        } else {
            $message = "This account is invalid or already verified!";
        }

        mysqli_close($conn);
    } else {
        $message = "Verification key was not found!";
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include("building_blocks/common_head_tags.php"); ?>
    <title>Verify email</title>
</head>
<body>
    <?php include("building_blocks/upper_bar.php"); ?>
    <main class="main-info">
        <?php echo $message; ?>
    </main>
    <?php include("building_blocks/footer.php") ?>
</body>
</html>
