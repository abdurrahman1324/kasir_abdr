<?php
session_start();
session_unset();
session_destroy();

// Redirect dengan parameter query string
header('Location: login.php?logout=success');
exit;
?>
