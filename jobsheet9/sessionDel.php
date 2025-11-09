<?php
    session_start(); 
?>
<!DOCTYPE html>
    <html>
        <body>
            <?php
                // hapus semua variabel session
                session_unset();
                // hancurkan session
                session_destroy();
                echo "All session variables are now removed, and the session is destroyed.";
            ?>
    </body>
</html>
