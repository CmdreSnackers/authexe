<?php
session_start();
// make sure user is logged in
if(isset($_SESSION['user'])) {
    // delete the user session data
    unset($_SESSION['user']);
    unset($_SESSION['add_csrf_token']);
    unset($_SESSION['remove_csrf_token']);
    // redirect user back to index
    header('Location: /login');
    exit;
} else {
    header('Location: /login');
    exit;
}
?>
