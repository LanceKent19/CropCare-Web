<?php
session_name('cropcare_session');
session_start();
session_unset();
session_destroy(); 
header("Location: index.php");
exit;

?>