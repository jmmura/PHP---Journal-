<html>
<?php
    header("Location: index.html");
    session_start();
    session_unset();
    exit();
?>
</html>