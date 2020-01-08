<?php
require "../connexion_bdd.php";
$db = connexionBase();
//$objetPdo = new PDO('mysql:host=localhost;charset=utf8;dbname=jarditou', 'root', '');
date_default_timezone_set('Europe/Paris'); // Pour récupérer l'heure locale
$date = date("Y-m-d H:i:s");
//$pro_cat_id = $_POST["pro_cat_id"];

// Requête SQL pour insérer les valeurs ajoutées dans le formulaire d'ajout
$pdoStat = $db ->prepare("INSERT INTO produits(pro_ref, pro_cat_id, pro_libelle, pro_description, pro_prix, pro_stock, pro_couleur, pro_bloque, pro_d_ajout)
VALUES(:pro_ref, :pro_cat_id, :pro_libelle, :pro_description, :pro_prix, :pro_stock, :pro_couleur, :pro_bloque, '".$date."')");

$pdoStat->bindValue(':pro_ref', $_POST['reference'], PDO::PARAM_STR); // bindValue : Associe une valeur à un paramètre - $_POST['reference'] : on récupère le name du fichier produits_ajout.php
$pdoStat->bindValue(':pro_cat_id', $_POST['pro_cat_id'], PDO::PARAM_STR);
$pdoStat->bindValue(':pro_libelle', $_POST['libelle'], PDO::PARAM_STR);
$pdoStat->bindValue(':pro_description', $_POST['description'], PDO::PARAM_STR);
$pdoStat->bindValue(':pro_prix', $_POST['prix'], PDO::PARAM_STR);
$pdoStat->bindValue(':pro_stock', $_POST['stock'], PDO::PARAM_STR);
$pdoStat->bindValue(':pro_couleur', $_POST['couleur'], PDO::PARAM_STR);

// Condition si le produit n'est pas bloqué alors cela affiche 0 ou NULL dans le tableau phpMyAdmin
if ($_POST['bloque']==0) {
    $bloque = NULL;
} else if  ($_POST['bloque']==1) { // Si le produit est bloqué alors cela affiche 1 dans le tableau phpMyAdmin
    $bloque = 1;
}

$pdoStat->bindValue(':pro_bloque', $bloque, PDO::PARAM_STR);

$InsertIsOk = $pdoStat ->execute();

if($InsertIsOk){
    //$message = "Le produit a été rajouté dans la base de données";
    header("Location: ../tableau.php"); // Si le produit a bien été ajouté, il y a une redirection ver le tableau.php
}
else{
    $message = "Echec de l'insertion";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Validation du produit</title>
</head>
<body>
    <h1>Ajout du produit</h1>
    <p><?php echo $message; ?></p> <!-- Affichage du message confirmant l'insertion du produit ou l'échec d'insertion
</body>
</html>