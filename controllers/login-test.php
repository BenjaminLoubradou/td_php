<?php

// 1 - connexion à la DB
require '../kernel/db_connect.php';

// 2 - récupérer les données du form
require '../kernel/functions.php';
require '../models/user.php';
// on défini un tableau de ce que l'on attend parmi les clés des champs.
$fields_required = ['login','password'];
// fonction dans le fichier function.php
$datas_form = extractDatasForm($_POST,$fields_required);

// 3 - vérifier que tous les champs sont remplis
$messages = [];
if(in_array(null,$datas_form)){
    $messages[] = 'Tous les messages sont obligatoires';
}

// 4 - lancer une requete sql pour récupérer le user avec le login saisi
$user = findOneUserBy('login',$datas_form['login']);
var_dump($user);
/*if(count($resultat) >0 ){
    $messages[] = "Ce login est déjà utilisé.";
}*/

die();
// 5 - comparer le mot de passe stocké dans la db à celui saisi par le user
$resultat2 = findOneUserBy('password',password_hash($datas_form['password']));
/*if(count($resultat2) >0 ){
    $messages[] = "Ce login est déjà utilisé.";
}*/
// 6 - si comparaison ok > is_admin == 1 ?
// 7 - si user est admin > démarrage session, stockage dans la session d'une épreuve d'identification.
// 8 - redirection du user vers la page gestion.php (page à créer)
// 9 - gestion des erreurs avec la variable $_SESSION['messages']
// 10 - on cumule les messages d'erreur et on redirige le user sur le form de login avec affichage de toutes ses erreurs.

// démarrage session pour stocker les messages d'erreurs:
session_start();
$_SESSION['messages'] = $messages;
header('Location:../backend/index.php');