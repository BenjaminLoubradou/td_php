<?php
// recupere la session
session_start();
// destruction session
session_destroy();
// redirection vers page login
header('Location: ../backend/index.php');
exit();
