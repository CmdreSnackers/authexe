<?php
session_start();
// make sure user is logged in
if(isset($_SESSION['user'])) {
    // delete the user session data
    unset($_SESSION['user']);
    // redirect user back to index
    header('Location: /login.php');
    exit;
} else {
    header('Location: /login.php');
    exit;
}
?>
