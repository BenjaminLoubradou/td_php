<?php
function findOneUserBy($critere,$value){
    //SQL
    // permet de récupérer la variable $db qui se trouve dans le fichier db_connect.php |
    // le fichier register.php fais office de passerelle entre les fichiers user et db_connect
    global $db;


    //$sql = "SELECT * FROM users WHERE email = 'loubradou.benjamin@hotmail.fr'";
    $sql = "SELECT * FROM users WHERE $critere = :value";

    // on prépare en fonction de la requete sql que la base reçoit de la base de donnée.
    $stmt = $db->prepare($sql); // met en memoire avant d'executer
    $stmt->bindParam(':value',$value,PDO::PARAM_STR); // permet de filtrer pour se protéger contre les noms de login mal intentionné.
    // executer la requête
    $resultat = $stmt->execute();

    $stmt->setFetchMode(PDO::FETCH_ASSOC); // on appelle un mode qui va les valeurs dans un tab associatif.
    $resultat = $stmt->fetchAll(); // fetchAll récupère toutes les résultats
//    var_dump($resultat);

    return $resultat;
}

function addUser(array $datas_tab){
    global $db;
    $sql = "INSERT INTO users (login,email,password,nom,prenom,is_admin,created_at) VALUES (:login,:email,:password,:nom,:prenom,:is_admin,:created_at)";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(":login", $datas_tab['login'], PDO::PARAM_STR);
    $stmt->bindParam(":email", $datas_tab['email'], PDO::PARAM_STR);
    $stmt->bindParam(":password", password_hash($datas_tab['password'], PASSWORD_ARGON2I),PDO::PARAM_STR);
    $stmt->bindParam(":nom", $datas_tab['nom'], PDO::PARAM_STR);
    $stmt->bindParam(":prenom", $datas_tab['prenom'], PDO::PARAM_STR);
    $stmt->bindValue(":is_admin", 0, PDO::PARAM_BOOL);
    $stmt->bindParam(":created_at", date('Y-m-d H:i:s'), PDO::PARAM_STR);
    $stmt->execute();
};

function findAllUsers(){
    $sql = "SELECT * FROM users";
    global $db;

    $stmt = $db->prepare($sql);
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $resultat = $stmt->fetchAll();
    return $resultat;
}