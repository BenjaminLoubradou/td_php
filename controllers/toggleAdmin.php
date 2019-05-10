<?php
//print_r($_GET);
$id = isset($_GET['id']) ? $_GET['id'] : null;
if (empty($id)){
    header('Location: ../index.php');
    exit();
}
// Se connecter à la db
require '../kernel/db_connect.php';

// récupérer le model user pour mettre à jour le user dans la table > is_admin = 1
require '../models/user.php';
setAdmin($_GET['id']);

// stocker un message de confirmation dans la session
session_start();
$_SESSION['messages'] = "Le user est admin";
header('Location: ../backend/gestion.php');
// redirection vers la page gestion.php avec l'affichage du message