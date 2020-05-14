<?php 
    function set_comment($conn) {
        if (isset($_POST["submit"])) {
            $user_id = $_SESSION["user_id"];
            $username = $_SESSION["username"];
            $date = $_POST["date"];
            $message = mysqli_real_escape_string($conn, $_POST["message"]);

            $sql_insert = "INSERT INTO comments (user_id, date, message, author) VALUES ('$user_id', '$date', '$message', '$username')";

            if (!mysqli_query($conn, $sql_insert)) {
                echo "query error: " . mysqli_error($conn);
            }
        }
    }

    function get_comments($conn) {
        $sql_statement = "SELECT * FROM comments";
        $result = mysqli_query($conn, $sql_statement);

        if (!$result) {
            echo "query error: " . mysqli_error($conn);
            return "";
        }

        $comments = mysqli_fetch_all($result, MYSQLI_ASSOC);

        foreach ($comments as $comment) {
            echo    "<article class='main-content__comment comment'>
                        <header class='comment-header'>
                            <h1 class='comment-header__h1'>"
                                .$comment["author"]." <time class='time' date-time='".$comment["date"]."'>".$comment["date"].
                            "</time></h1>
                        </header>
                        <div class='comment-text-area'>
                            <p class='comment-message'>".nl2br($comment["message"])."</p>
                        </div>
                        <form class='comment-buttons-form' method='POST' action='index.php'>
                            <input type='hidden' name='id' value='".$comment["id"]."'>".
                        (is_logged_in() && $comment["user_id"] == $_SESSION["user_id"] ? 
                        "<button type='submit' name='comment-delete' class='comment-buttons-form-button'>Delete</button>" : "")."
                       </form>
                    </article>";
        }

        mysqli_free_result($result);
        mysqli_close($conn);
    }

    function delete_comments($conn) {
        if (isset($_POST["comment-delete"])) {
            $id = $_POST["id"];

            $sql_delete_column = "DELETE FROM comments WHERE id='$id'";
            if (!mysqli_query($conn, $sql_delete_column)) {
                echo "query error: " . mysqli_error($conn);
            }
        }
    }
?>
