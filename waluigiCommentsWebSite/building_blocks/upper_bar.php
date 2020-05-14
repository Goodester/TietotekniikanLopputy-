<section class="upper-bar">
        <header class="upper-bar__header">
            <a class="upper-bar__main-link" href="index.php"><h1 class="upper-bar__main-title">Waluigi Comments</h1></a>
            <div class="upper-bar__text-cont">
                <h3 class="upper-bar__sub-title">The favorite comment section of Waluigi fans</h3>
                <p class="upper-bar__short-description"> Comment anything about Waluigi here! Logging in before commenting is mandatory.</p>
            </div>
            <a class="upper-bar__link" href="index.php">
                <img class="logo" src="images/waluigi.png" alt="Your browser can't display an image.">
            </a>
            <ul class="upper-bar__buttons">
                <li class="upper-bar__register-button button">
                    <a class="upper-bar__log-in-button-link button-text" href="registering_page.php">
                        <p>Register</p>
                    </a>
                </li>
                <li class="upper-bar__log-in-button button">
                    <a class="upper-bar__log-in-button-link button-text" href=<?php echo is_logged_in() ? "config/log_out.php" : "log_in_page.php"; ?> >
                        <p> <?php echo is_logged_in() ? "Log Out" : "Log In"; ?> </p>
                    </a>
                </li>
            </ul>
        </header>
</section>
