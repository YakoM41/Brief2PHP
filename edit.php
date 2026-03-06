<?php

require 'config.php';

if(!isset($_GET['id'])){
    header("location: index.php");
    exit();
}
$id=$_GET['id'];

//requête sql pour recup les donnees de l'auteur a modif
$stmt = $pdo-> prepare("SELECT * FROM produits WHERE ID = :id");
$stmt -> execute([':id' => $id]);
$produit = $stmt->fetch(PDO::FETCH_ASSOC);


//requete pour modif
$modif = $pdo-> prepare("UPDATE produits SET Nom=:nom, Prix=:prix, Stock=:stock  WHERE ID = :id");
// il y a aussi un if pour verifier que la method post a bien été soumise
if($_SERVER['REQUEST_METHOD'] === "POST") {
    $newNom = $_POST['Nom'];
    $newPrix = $_POST['Prix'];
    $newStock = $_POST['Stock'];

    $modif->execute([
            ':nom' => $newNom,
            ':prix' => $newPrix,
            ':stock' => $newStock,
            ':id'   => $id
    ]);

    header("Location: index.php");

}
?>

<!doctype html>
<html lang=fr>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Modifier les informations du produit</title>
    <style>
        body {
            font-family: sans-serif;
            margin: 40px;
            line-height: 1.6;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            flex-direction: column;
        }

        form {
            max-width: 400px;
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        label {
            display: flex;
            flex-direction: column;
            font-weight: bold;
        }

        input {
            padding: 8px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            padding: 10px;
            margin-top: 7px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
<h1>Modification des informations</h1>
<!-- Formulaire pour modifier les données du produit, pour ca utiliser le parametre value de la balise input (pré-rempli le form des données deja existantes)-->
<form action="edit.php?id=<?= $id; ?>" method="post">
    <label for="Nom"> Nom :
        <input type="text" id="Nom" name="Nom" value="<?= htmlspecialchars($produit['Nom']) ?>">
    </label>
    <label for="Prix"> Prix :
        <input type="number" id="Prix" name="Prix" value="<?= htmlspecialchars($produit['Prix']) ?>">
    </label>
    <label for="Stock"> Stock :
        <input type="number" id="Stock" name="Stock" value="<?= htmlspecialchars($produit['Stock']) ?>" >
    </label>
    <button type="submit" onclick="return confirm('Confirmez-vous la modification des informations pour ce produit ?');">Modifier</button>
</form>

</body>
</html>
