<?php

// Etape 1 > connection à la base de donnée
require '../kernel/db_connect.php';

// Etape 2 > récupérer les données du formulaire.
require '../kernel/functions.php';
require '../models/user.php';

// on défini un tableau de ce que l'on attends parmi les clés des champs.
$fields_required = ['login','password','email','nom','prenom'];

// function dans le fichier function.php
$datas_form = extractDatasForm($_POST,$fields_required);
//var_dump($datas_form); // affiche les booleans

// Etape 3 > vérifier que tous les champs sont remplies
$messages = [];
if(in_array(null,$datas_form)){
    $messages[] = 'Tous les messages sont obligatoires';
}

// Etape 4 >
// vérifier que le login est unique ( pas déja dans le DB)

$resultat = findOneUserBy('login',$datas_form['login']);
if(count($resultat) >0){
    $messages[] = "Ce login est déjà utilisé.";
}

// Etape 5 >
//a) vérifier le format de l'email
if(filter_var($datas_form['email'], FILTER_VALIDATE_EMAIL) == false){
    $messages[] = "votre email est invalide";
}
// vérigier que l'email est unique
$resultat2 = findOneUserBy('email',$datas_form['email']);
if(count($resultat2) >0){
    $messages[] = "Un utilisateur est déjà inscrit avec cet email. Avez-vous déjà un compte ?";
}

// Etape 6 > vérifier que le mdp fait au moins 8 caractère.
$password = $datas_form['password'];
if(strlen($password) <8){
    $messages[] = "Votre mot de passe doit faire au minimum 8 caractère.";
}

// Etape 7 > si tout est ok
// > insertion des datas dans la DB > redirection vers la page de confirmation inscription.
if(count($messages) == 0){
    // executer une requete SQL pour tranferer les données saisies dans le form de la base de donnée.
    addUser($datas_form);

    // démarrer la session
    session_start();
    //
    $_SESSION['is_subcribe'] = true;
    header('Location:../confirmation.php');
    exit();
}


// Géneral > gestion des erreurs: quand un /ou N probleem se déclenchent , il faut afficher ts les messages d'erreurs en même tps sur la page d'inscription.

// démarrage session pour stocker les messages d'erreurs:
session_start();
$_SESSION['messages'] = $messages;
header('Location:../index.php');