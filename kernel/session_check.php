<?php
// récupérer la session
session_start();
// verifier la preuve d'identification et d'autorisation
if(isset($_SESSION['is_admin']) == false){
    $_SESSION['messages'] = ['Accès interdit'];
    header('Location: ../backend/index.php');
    exit();
}

// redirection vers page login si pas autorisé.