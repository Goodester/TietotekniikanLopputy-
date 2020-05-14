<?php
    include("config/session.php");
    include("config/establish_db_conn.php");
    include("config/comments.php");

    date_default_timezone_set("Europe/Helsinki");

    $comment_errors = ["no_numbers_or_letters" => false];

    // comment submitting
    if (isset($_POST["submit"])) {
        if (preg_match("/[a-z]/i", $_POST["message"])) {
            $_POST["message"] = trim($_POST["message"]);
            set_comment($conn);
        } else {
            $comment_errors["no_numbers_or_letters"] = true;
        }
    }

    // comment deleting
    delete_comments($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include("building_blocks/common_head_tags.php"); ?>
    <title>Waluigi Comments</title>
</head>
<body>
    <?php include("building_blocks/upper_bar.php"); ?>
    <main class="main-content">
        <?php 
            if (is_logged_in()) {
                echo "You're logged in as {$_SESSION['username']}.";
            } else {
                echo "You're currently logged out. In order to leave comments about Waluigi, you need to log in.<br> 
                     If you don't own an account yet, you can create one <a class='link' href='registering_page.php'>here</a>.";
            }
        ?>
        <section class="main-content__comments">
            <?php
                if (is_logged_in()) {
                    echo 
                    "<form method='POST' action='' class='main-content__form'>
                        <input type='hidden' name='date' value='".date('Y-m-d H:i:s')."''>
                        <textarea name='message' class='main-content__text-area'></textarea>".
                        ($comment_errors["no_numbers_or_letters"] ? "You can't comment messages without letters or numbers!" : "")
                        ."<button type='submit' name='submit' class='button main-button'><p class='button-text main-button-text'>Comment</p></button>
                    </form>";
                }
            ?>
            <hr class="separator">
            <?php 
                get_comments($conn);
            ?>
        </section>
    </main>

    <?php include("building_blocks/footer.php"); ?>
</body>
</html>
